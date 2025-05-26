<?php

namespace App\Services;

use App\Models\Admin\Franchise;

class FranchisesService
{
    public function getAllFranchises() {
        return Franchise::all();
    }

}
