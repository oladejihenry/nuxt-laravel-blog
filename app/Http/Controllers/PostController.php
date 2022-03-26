<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostRequest;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Category;

class PostController extends Controller
{   
    /**
    *   Display all post in the order of created_at.
    *   And also in desc order then paginate.
    *   @return \Illuminate\Http\Response
    */
    public function index()
    {
        $posts = Post::orderBy('created_at', 'desc')->paginate(10)->through(fn($post) =>[
            'id' => $post->id,
            'title' => $post->title,
            'body' => $post->body,
            'excerpt' => $post->excerpt,
            'updated_at' => $post->updated_at->format('Y/m/d H:i'),
        ]);

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

        $post->categories()->attach($request->catSelected);
        
        return response()->json([
            'post' => $post,
            'message' => 'Post created successfully.'
        ], 200);
    }

    /**
     * Display/Edit the specified post.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $post = Post::find($id);
        $mainCat = Category::all();
        $cat = $post->categories()->get();
        return response()->json([
            'post' => $post, 
            'categories' => $cat,
            'mainCategories' => $mainCat
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(PostRequest $request, Post $post)
    {
        $post->update([
            'title' => $request->title,
            'body' => $request->body,
            'excerpt' => $request->excerpt,
        ]);

        $post->categories()->sync($request->categories);
        $post->categories()->sync($request->mainCategories);

        return response()->json([
            'post' => $post,
            'message' => 'Post updated successfully.'
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        $post->delete();
        return response()->json([
            'message' => 'Post deleted successfully.'
        ], 200);
    }
    

    public function trashed()
    {
        $posts = Post::onlyTrashed('created_at', 'desc')->paginate(10)->through(fn($post) =>[
            'id' => $post->id,
            'title' => $post->title,
            'body' => $post->body,
            'excerpt' => $post->excerpt,
            'deleted_at' => $post->deleted_at->format('Y/m/d H:i'),
        ]);

        return response()->json($posts);
    }

    public function restore($id)
    {
        $post = Post::onlyTrashed()->find($id);
        $post->restore();
        return response()->json([
            'message' => 'Post restored successfully.'
        ], 200);
    }

    public function forceDelete($id)
    {
        $post = Post::onlyTrashed()->find($id);
        $post->categories()->detach();
        $post->forceDelete();
        return response()->json([
            'message' => 'Post deleted successfully.'
        ], 200);
    }
}
