<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostRequest;
use Illuminate\Http\Request;
use App\Models\Post;

class PostController extends Controller
{
    public function store(PostRequest $request)
    {
        $post = Post::create($request->all());
        return response()->json([
            'post' => $post,
            'message' => 'Post created successfully.'
        ], 200);
    }
}
