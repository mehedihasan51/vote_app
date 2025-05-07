<?php

namespace App\Http\Controllers\Api\Frontend;

use App\Http\Controllers\Controller;
use App\Helpers\Helper;
use App\Models\News;

class NewsController extends Controller
{
    public function index()
    {
        $news = News::with(['user:id,name'])->where('status', 'active')->orderBy('id', 'desc')->paginate(4);
        $data = [
            'news' => $news
        ];
        return Helper::jsonResponse(true, 'get all news', 200, $data);

    }

    public function show($id)
    {
        $news = News::with(['user:id,name'])->where('id', $id)->first();
        $data = [
            'news' => $news
        ];
        return Helper::jsonResponse(true, 'get single news', 200, $data);

    }
}