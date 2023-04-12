<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Models\Category;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $posts = Post::all();
        $categories = Category::all();

        return view("posts.create", compact('posts', 'categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePostRequest $request)
    {
        $user = Auth::user();
        $data = $request->validated();
        $post = Post::create($data);

        if (key_exists('image', $data)) {
            $path = Storage::put('posts', $data['image']);
            $post->image = $path;
        }

        $post->visibility = $request->has('visibility');
        $post->user_id = $user->id;
        $post->save();

        if ($request->has("categories")) {
            $post->categories()->attach($data["categories"]);
        }

        return redirect()->route('posts.show', $post->id);
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        $user_id = auth()->user()->id;
        $posts = Post::where('user_id', $user_id)
            ->orderBy('created_at')
            ->get();

        if(Auth::user()->role_id == '1' ? true : Auth::user()->role_id == '2') {
            $posts = Post::all();
        }

        return view("posts.show", compact('post', 'posts'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        $categories = Category::all();

        return view("posts.edit", compact('post', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePostRequest $request, Post $post)
    {
        $data = $request->validated();
        $post->update($data);

        if (key_exists("image", $data)) {
            $path = Storage::put("posts", $data["image"]);
            Storage::delete($post->image);

            $post->image = $path;
        }

        $post->visibility = $request->has('visibility');

        $post->save();

        $post->categories()->sync($data['categories']);

        return redirect()->route('posts.show', $post->id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        if ($post->image) {
            Storage::delete($post->image);
        }

        $post->categories()->detach();
        $post->delete();

        return redirect()->route('dashboard');
    }
}
