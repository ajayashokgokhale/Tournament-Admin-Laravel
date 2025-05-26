<?php

namespace App\Services;

use App\Models\Admin\Event;

class EventsService
{
    public function getAllEvents()
    {
        return Event::all();
    }

}
