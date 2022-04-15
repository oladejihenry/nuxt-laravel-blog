<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Category;

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
            'featured_image' => $post->featured_image,
            'slug' => $post->slug,
            'category' => $post->categories->pluck('name')->implode(', '),
            'category_slug' => $post->categories->pluck('slug')->implode(', '),
            'created_at' => $post->created_at->format('d F Y'),
            'username' => $post->user->username,
            'profile_image' => $post->user->profile_image,
        ]);

        $cat = Category::all();

        return response()->json([
            'posts' => $posts,
            'cat' => $cat,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function show($slug)
    {
        $post = Post::where('slug', $slug)->firstOrFail();

        return response()->json([
            'title' => $post->title,
            'body' => $post->body,
            'excerpt' => $post->excerpt,
            'slug' => $post->slug,
            'featured_image' => $post->featured_image,
            'main_image' => $post->main_image,
            'category' => $post->categories->pluck('name')->implode(', '),
            'category_slug' => $post->categories->pluck('slug')->implode(', '),
            'created_at' => $post->created_at->format('d F Y'),
            'username' => $post->user->username,
            'profile_image' => $post->user->profile_image,
            'description' => $post->user->description,
        ]);
    }

    public function category(Category $category)
    {
        $posts = $category->posts()->orderBy('created_at', 'desc')->paginate(10)->through(fn($post) =>[
            'id' => $post->id,
            'title' => $post->title,
            'body' => $post->body,
            'excerpt' => $post->excerpt,
            'featured_image' => $post->featured_image,
            'slug' => $post->slug,
            'category' => $post->categories->pluck('name')->implode(', '),
            'created_at' => $post->created_at->format('d F Y'),
            'username' => $post->user->username,
        ]);

        return response()->json([
            'posts' => $posts,
            'cat' => Category::all(),
            'category' => $category
        ]);
    }
}
