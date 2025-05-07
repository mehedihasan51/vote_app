<?php

namespace App\Http\Controllers\Api\Frontend;

use App\Http\Controllers\Controller;
use App\Helpers\Helper;
use App\Models\Event;

class EventController extends Controller
{
    public function index()
    {
        $events = Event::where('status', 'active')->orderBy('id', 'desc')->paginate(3);
        $data = [
            'events' => $events
        ];
        return Helper::jsonResponse(true, 'get all news', 200, $data);

    }

    public function fourItem()
    {
        $events = Event::where('status', 'active')->orderBy('id', 'desc')->limit(4)->get();
        $data = [
            'events' => $events
        ];
        return Helper::jsonResponse(true, 'get all news', 200, $data);

    }

    public function show($id)
    {
        $event = Event::where('id', $id)->first();
        $data = [
            'event' => $event
        ];
        return Helper::jsonResponse(true, 'get single news', 200, $event);

    }
}