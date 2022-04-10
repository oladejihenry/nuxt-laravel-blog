<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::orderBy('created_at', 'desc')->paginate(10)->through(fn($categories) =>[
            'id' => $categories->id,
            'name' => $categories->name,
            'description' => $categories->description,
            'updated_at' => $categories->updated_at->format('Y/m/d H:i'),
        ]);
      

        return response()->json($categories);
    }


    public function store(CategoryRequest $request)
    {
        $category = Category::create([
            'name' => $request->name,
            'description' => $request->description,
        ]);
        return response()->json([
            'category' => $category,
            'message' => 'Post created successfully.'
        ], 200);
    }

    public function edit($id)
    {
        $category = Category::find($id);
        return response()->json($category);
    }

    public function update(CategoryRequest $request, Category $category)
    {

        $category->update([
            'name' => $request->name,
            'description' => $request->description,
        ]);
        return response()->json([
            'category' => $category,
            'message' => 'Post updated successfully.'
        ], 200);
    }
}
