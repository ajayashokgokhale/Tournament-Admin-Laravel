<?php

namespace App\Services;

use App\Models\Admin\Contest;

class ContestsService
{
    public function getAllContests()
    {
        return Contest::with(['event', 'franchise1', 'franchise2'])->get();
    }
}
