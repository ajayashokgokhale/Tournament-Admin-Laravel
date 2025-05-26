<?php

namespace App\Services;


use App\Models\Admin\Player;

class PlayersService
{
    public function getAllPlayers()
    {
        return Player::with('franchise')->get();
    }
}
