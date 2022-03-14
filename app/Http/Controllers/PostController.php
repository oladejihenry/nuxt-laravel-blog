<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostRequest;
use Illuminate\Http\Request;
use App\Models\Post;

class PostController extends Controller
{   
    /**
    *   Display all post in the order of created_at.
    *   And also in desc order then paginate.
    *   @return \Illuminate\Http\Response
    */
    public function index()
    {
        $posts = Post::orderBy('created_at', 'desc')->paginate(10);

        return response()->json($posts);
    }

    /**
     * Stores new post.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
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
