<?php

namespace App\Http\Controllers\Api\Frontend;

use App\Http\Controllers\Controller;
use App\Helpers\Helper;
use App\Models\FAQ;

class FaqController extends Controller
{
    public function index()
    {
        $faqs = FAQ::where('status', 'active')->orderBy('id', 'desc')->paginate(4);
        $data = [
            'faqs' => $faqs
        ];
        return Helper::jsonResponse(true, 'get all news', 200, $data);

    }
}