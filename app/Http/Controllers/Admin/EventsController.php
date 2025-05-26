<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Event;
use App\Services\EventsService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Intervention\Image\ImageManagerStatic as Image;

class EventsController extends Controller
{
    //
    protected EventsService $eventsService;

    public function __construct(EventsService $eventsService)
    {
        $this->eventsService = $eventsService;
    }

    public function home()
    {
        $data = [];
        $data['events'] = $this->eventsService->getAllEvents();
        return view('admin.events.home', $data);
    }

    public function newEvent(Request $request)
    {
        $validated = $request->validate([
            'event_name' => 'required|string|max:255',
            'event_start' => 'required|date|after:now',
            'event_end' => 'required|date|after:event_start',
            'event_location' => 'required|string|max:255',
            'event_photo' => 'nullable|image|mimes:png,jpg,jpeg|max:2048', // Max 2MB
            'event_youtube_link' => 'nullable|url|max:255',
            'event_status' => 'required|in:upcoming,ongoing,completed',
        ]);

        if ($request->hasFile('event_photo')) {
            $validated['event_photo'] = $this->uploadPhoto($request->file('event_photo'));
        }

        $event = Event::create($validated);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Event created successfully',
                'event' => $event
            ], 201);
        }

        return redirect()->route('admin.events')->with('success', 'Event created successfully');
    }

    public function edit(Request $request, $id)
    {
        $event = Event::findOrFail($id);

        if ($request->isMethod('get')) {
            return response()->json([
                'success' => true,
                'event' => $event
            ]);
        }

        $validated = $request->validate([
            'event_name' => 'required|string|max:255',
            'event_start' => 'required|date',
            'event_end' => 'required|date|after:event_start',
            'event_location' => 'required|string|max:255',
            'event_photo' => 'nullable|image|mimes:png,jpg,jpeg|max:2048',
            'event_youtube_link' => 'nullable|url|max:255',
            'event_status' => 'required|in:upcoming,ongoing,completed',
        ]);

        if ($request->hasFile('event_photo')) {
            // Delete old photo if it exists
            if ($event->event_photo && file_exists(public_path($event->event_photo))) {
                unlink(public_path($event->event_photo));
            }
            $validated['event_photo'] = $this->uploadPhoto($request->file('event_photo'));
        }

        $event->update($validated);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Event updated successfully',
                'event' => $event
            ]);
        }

        return redirect()->route('admin.events')->with('success', 'Event updated successfully');
    }

    public function delete(Request $request, $id)
    {
        $event = Event::findOrFail($id);
        $event->event_status = 'completed';
        $event->save();

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Event marked as completed successfully',
                'event' => $event
            ]);
        }

        return redirect()->route('admin.events')->with('success', 'Event marked as completed successfully');
    }

    private function uploadPhoto($file)
    {
        $randomString = Str::random(15);
        $timestamp = date('YmdHis');
        $extension = $file->getClientOriginalExtension();
        $filename = "photo_{$randomString}{$timestamp}.{$extension}";
        $path = 'eventsphoto/' . $filename;

        // Resize image to max 300x200 while maintaining aspect ratio
        $image = Image::make($file)->resize(300, 200, function ($constraint) {
            $constraint->aspectRatio();
            $constraint->upsize();
        })->save(public_path($path));

        return $path;
    }
}
