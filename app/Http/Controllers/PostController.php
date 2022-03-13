<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostRequest;
use Illuminate\Http\Request;
use App\Models\Post;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::orderBy('created_at', 'desc')->paginate(10);

        return response()->json($posts);
    }

    public function store(PostRequest $request)
    {  
        $post = Post::create([
            'title' => $request->title,
            'body' => $request->body,
            'excerpt' => $request->excerpt,
            'user_id' => auth()->id(),
        ]);
        return response()->json([
            'post' => $post,
            'message' => 'Post created successfully.'
        ], 200);
    }
}
