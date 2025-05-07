<?php

namespace App\Http\Controllers\Api\Frontend;

use App\Http\Controllers\Controller;
use App\Helpers\Helper;
use App\Models\Leader;

class LeaderController extends Controller
{
    public function index()
    {
        $leaders = Leader::where('status', 'active')->orderBy('id', 'desc')->paginate(3);
        $data = [
            'leaders' => $leaders
        ];
        return Helper::jsonResponse(true, 'get all news', 200, $data);

    }

    public function show($id)
    {
        $leader = Leader::where('id', $id)->first();
        $data = [
            'leader' => $leader
        ];
        return Helper::jsonResponse(true, 'get single news', 200, $data);

    }
}