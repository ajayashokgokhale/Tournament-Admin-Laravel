<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Event;
use App\Models\Admin\Franchise;
use App\Models\Admin\Contest;
use App\Services\FranchisesService;
use Illuminate\Http\Request;

class BasketballAdmin extends Controller
{
    //
    protected $franchisesService;  // Correct the typo

    public function __construct(FranchisesService $franchisesService) {
        $this->franchisesService = $franchisesService;
    }
    

    public function home(){
        $totalFranchises = Franchise::count();

        // Contest statistics
        $pastContests = Contest::where('status', 'completed')->count();
        $todayContests = Contest::where('status', 'live')
            ->whereDate('match_datetime', now()->toDateString())
            ->count();
        $upcomingContests = Contest::where('status', 'scheduled')
            ->where('match_datetime', '>', now())
            ->count();

        $contests = Contest::with(['franchise1', 'franchise2'])
            ->latest()
            ->take(5)
            ->get(['id', 'franchises_1_id', 'franchises_2_id', 'match_datetime', 'status']);

        return view('admin.home', compact(
            'totalFranchises',
            'pastContests',
            'todayContests',
            'upcomingContests',
            'contests'
        ));
    }


    public function players() {}

    public function events() {}
    public function matches() {}
}

