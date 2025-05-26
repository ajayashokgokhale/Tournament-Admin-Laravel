<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Contest;
use App\Models\Admin\Event;
use App\Models\Admin\Franchise;
use App\Services\ContestsService;
use Illuminate\Http\Request;

class ContestsController extends Controller
{
    //
    protected ContestsService $contestsService;

    public function __construct(ContestsService $contestsService)
    {
        $this->contestsService = $contestsService;
    }

    public function home()
    {
        $data = [];
        $data['contests'] = $this->contestsService->getAllContests();
        $data['events'] = Event::where('event_status', '!=', 'completed')->get();
        $data['franchises'] = Franchise::where('status', 'active')->get();
        return view('admin.contests.home', $data);
    }

    public function newContest(Request $request)
    {
        $validated = $request->validate([
            'match_title' => 'required|string|max:255',
            'match_datetime' => 'required|date|after:now',
            'match_location' => 'required|string|max:255',
            'event_id' => 'required|exists:events,id',
            'franchises_1_id' => 'required|exists:franchises,id|different:franchises_2_id',
            'franchises_2_id' => 'required|exists:franchises,id|different:franchises_1_id',
            'score_1' => 'nullable|integer|min:0',
            'score_2' => 'nullable|integer|min:0',
            'status' => 'required|in:scheduled,live,completed',
        ]);

        $contest = Contest::create($validated);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Contest created successfully.',
                'match' => $contest->load(['event', 'franchise1', 'franchise2'])
            ], 201);
        }

        return redirect()->route('admin.frances')->with('success', 'Contest created successfully');
    }

    public function update(Request $request, $id)
    {
        $contest = Contest::findOrFail($id);

        if ($request->isMethod('get')) {
            return response()->json([
                'success' => true,
                'match' => $contest->load(['event', 'franchise1', 'franchise2'])
            ]);
        }

        $validated = $request->validate([
            'match_title' => 'required|string|max:255',
            'match_datetime' => 'required|date',
            'match_location' => 'required|string|max:255',
            'event_id' => 'required|exists:events,id',
            'franchises_1_id' => 'required|exists:franchises,id|different:franchises_2_id',
            'franchises_2_id' => 'required|exists:franchises,id|different:franchises_1_id',
            'score_1' => 'nullable|integer|min:0',
            'score_2' => 'nullable|integer|min:0',
            'status' => 'required|in:scheduled,live,completed',
        ]);

        $contest->update($validated);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Contest updated successfully.',
                'match' => $contest->load(['event', 'franchise1', 'franchise2'])
            ]);
        }

        return redirect()->route('admin.frances')->with('success', 'Contest updated successfully');
    }

    public function delete(Request $request, $id)
    {
        $contest = Contest::findOrFail($id);
        $contest->status = 'completed';
        $contest->save();

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Contest marked as completed successfully.',
                'match' => $contest->load(['event', 'franchise1', 'franchise2'])
            ]);
        }

        return redirect()->route('admin.frances')->with('success', 'Contest marked as completed successfully');
    }
}
