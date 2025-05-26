<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Franchise;
use App\Models\Admin\Player;
use App\Services\PlayersService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Intervention\Image\ImageManagerStatic as Image;

class PlayersController extends Controller
{
    //
    protected PlayersService $playersService;

    public function __construct(PlayersService $playersService)
    {
        $this->playersService = $playersService;
    }

    public function home()
    {
        $data = [];
        $data['players'] = $this->playersService->getAllPlayers();
        $data['franchises'] = Franchise::where('status', 'active')->get(); // For franchise dropdown
        return view('admin.players.home', $data);
    }

    public function newPlayer(Request $request)
    {
        $validated = $request->validate([
            'franchise_id' => 'required|exists:franchises,id',
            'name' => 'required|string|max:255',
            'position' => 'required|string|max:50',
            'photo' => 'nullable|image|mimes:png,jpg,jpeg|max:2048', // Max 2MB
            'status' => 'required|in:active,hold,inactive',
            'profile' => 'nullable|string',
            'youtube_link' => 'nullable|url|max:255',
        ]);

        if ($request->hasFile('photo')) {
            $validated['photo'] = $this->uploadPhoto($request->file('photo'));
        }

        $player = Player::create($validated);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Player created successfully',
                'player' => $player->load('franchise')
            ], 201);
        }

        return redirect()->route('admin.players')->with('success', 'Player created successfully');
    }

    public function edit(Request $request, $id)
    {
        $player = Player::findOrFail($id);

        if ($request->isMethod('get')) {
            return response()->json([
                'success' => true,
                'player' => $player->load('franchise')
            ]);
        }

        $validated = $request->validate([
            'franchise_id' => 'required|exists:franchises,id',
            'name' => 'required|string|max:255',
            'position' => 'required|string|max:50',
            'photo' => 'nullable|image|mimes:png,jpg,jpeg|max:2048',
            'status' => 'required|in:active,hold,inactive',
            'profile' => 'nullable|string',
            'youtube_link' => 'nullable|url|max:255',
        ]);

        if ($request->hasFile('photo')) {
            // Delete old photo if it exists
            if ($player->photo && file_exists(public_path($player->photo))) {
                unlink(public_path($player->photo));
            }
            $validated['photo'] = $this->uploadPhoto($request->file('photo'));
        }

        $player->update($validated);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Player updated successfully',
                'player' => $player->load('franchise')
            ]);
        }

        return redirect()->route('admin.players')->with('success', 'Player updated successfully');
    }

    public function delete(Request $request, $id)
    {
        $player = Player::findOrFail($id);
        $player->status = 'inactive';
        $player->save();

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Player marked as inactive successfully',
                'player' => $player->load('franchise')
            ]);
        }

        return redirect()->route('admin.players')->with('success', 'Player marked as inactive successfully');
    }

    private function uploadPhoto($file)
    {
        $randomString = Str::random(15);
        $timestamp = date('YmdHis');
        $extension = $file->getClientOriginalExtension();
        $filename = "photo_{$randomString}{$timestamp}.{$extension}";
        $path = 'playersphoto/' . $filename;

        // Resize image to max 300x200 while maintaining aspect ratio
        $image = Image::make($file)->resize(300, 200, function ($constraint) {
            $constraint->aspectRatio();
            $constraint->upsize();
        })->save(public_path($path));

        return $path;
    }
}
