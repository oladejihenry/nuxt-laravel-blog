<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;

class FrontEndController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::orderBy('created_at', 'desc')->paginate(10)->through(fn($post) =>[
            'id' => $post->id,
            'title' => $post->title,
            'body' => $post->body,
            'excerpt' => $post->excerpt,
            'slug' => $post->slug,
            'category' => $post->categories->pluck('name')->implode(', '),
            'created_at' => $post->created_at->format('d F Y'),
            'username' => $post->user->username,
        ]);

        return response()->json($posts);
    }
}
