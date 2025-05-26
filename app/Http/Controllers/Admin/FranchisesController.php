<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Franchise;
use App\Services\FranchisesService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class FranchisesController extends Controller
{
    //
    protected FranchisesService $franchisesService;  // Correct the typo

    public function __construct(FranchisesService $franchisesService) {
        $this->franchisesService = $franchisesService;
    }

    public function home() {
        $data = [];
        $data['franchises'] = $this->franchisesService->getAllFranchises();
        return view('admin.franchises.franchises_home', $data);
    }

    public function newFranchise(Request $request) {
        $validated = $request->validate([
            'name' => 'required|string|max:150',
            'email' => 'required|email|unique:franchises,email|max:255',
            'logo' => 'nullable|image|mimes:png,jpg,jpeg|max:2048', // Max 2MB
            'tagline' => 'nullable|string|max:255',
            'about_franchise' => 'nullable|string',
            'status' => 'required|in:active,hold,inactive',
        ]);

        if ($request->hasFile('logo')) {
            $validated['logo'] = $this->uploadLogo($request->file('logo'));
        }

        $franchise = Franchise::create($validated);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Franchise created successfully',
                'franchise' => $franchise
            ], 201);
        }

        return redirect()->route('admin.franchises')->with('success', 'Franchise created successfully');
    }

    public function edit(Request $request, $id)
    {
        $franchise = Franchise::findOrFail($id);

        if ($request->isMethod('get')) {
            return response()->json([
                'success' => true,
                'franchise' => $franchise
            ]);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:150',
            'email' => 'required|email|max:255|unique:franchises,email,' . $id,
            'logo' => 'nullable|image|mimes:png,jpg,jpeg|max:2048',
            'tagline' => 'nullable|string|max:255',
            'about_franchise' => 'nullable|string',
            'status' => 'required|in:active,hold,inactive',
        ]);

        if ($request->hasFile('logo')) {
            // Delete old logo if it exists
            if ($franchise->logo && file_exists(public_path($franchise->logo))) {
                unlink(public_path($franchise->logo));
            }
            $validated['logo'] = $this->uploadLogo($request->file('logo'));
        }

        $franchise->update($validated);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Franchise updated successfully',
                'franchise' => $franchise
            ]);
        }

        return redirect()->route('admin.franchises')->with('success', 'Franchise updated successfully');
    }

    public function delete(Request $request, $id)
    {
        $franchise = Franchise::findOrFail($id);
        $franchise->status = 'inactive';
        $franchise->save();

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Franchise marked as inactive successfully',
                'franchise' => $franchise
            ]);
        }

        return redirect()->route('admin.franchises')->with('success', 'Franchise marked as inactive successfully');
    }

    private function uploadLogo($file)
    {
        $randomString = Str::random(15);
        $timestamp = date('YmdHis');
        $extension = $file->getClientOriginalExtension();
        $filename = "logo_{$randomString}{$timestamp}.{$extension}";
        $path = 'franchiseslogo/' . $filename;

        // Resize image to max 300x200 while maintaining aspect ratio
        $image = Image::make($file)->resize(300, 200, function ($constraint) {
            $constraint->aspectRatio();
            $constraint->upsize();
        })->save(public_path($path));

        return $path;
    }
}
