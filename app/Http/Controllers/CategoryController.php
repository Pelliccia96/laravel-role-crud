<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Models\Category;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::all();
        $posts = Post::all();
        $categories = Category::all();

        return view('dashboard', compact('users', 'posts', 'categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();

        return view('posts.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCategoryRequest $request)
    {
        $data = $request->validated();
        $category = Category::create($data);

        $category->save();

        return redirect()->route('dashboard', $category->id);
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $id)
    {
        return view('posts.show', compact('category'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $id)
    {
        return view('posts.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePostRequest $request, Category $category)
    {
        $data = $request->validated();
        $category->update($data);
        $category->save();

        // $category->categories()->sync($data["categories"]);

        return redirect()->route('dashboard', $category->id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        $category->posts()->detach();
        $category->delete();

        return redirect()->route('dashboard');
    }
}
