<?php

namespace App\Http\Controllers\Api\Frontend;

use App\Http\Controllers\Controller;
use App\Helpers\Helper;
use App\Models\Post;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::with(['category', 'subcategory', 'user'])->where('status', 'active')->get();
        $data = [
            'posts' => $posts
        ];
        return Helper::jsonResponse(true, 'get all posts', 200, $data);

    }

    public function show($id)
    {
        $post = Post::with(['category', 'subcategory', 'user'])->where('id', $id)->first();
        $data = [
            'post' => $post
        ];
        return Helper::jsonResponse(true, 'get single posts', 200, $data);

    }
}