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

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::all();
        $posts = Post::all();
        $categories = Category::all();

        return view("admin.dashboard", compact('users', 'posts', 'categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $posts = Post::all();
        $categories = Category::all();

        return view("admin.create", compact('posts', 'categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePostRequest $request)
    {
        $user = Auth::user();
        $data = $request->validated();
        $post = Post::create($data);

        // Salviamo il file nello storage e recuperiamo il path
        // carico il file solo se ne ricevo uno
        if (key_exists('image', $data)) {
            // salvo in una variabile temporanea il percorso del nuovo file
            $path = Storage::put('posts', $data['image']);
            $post->image = $path;
        }

        $post->visibility = $request->has('visibility');
        $post->user_id = $user->id;
        $post->save();

        // Controlla che nei dati che il server sta ricevendo, ci sia un valore per la chiave "categories".
        if ($request->has("categories")) {
            // if (key_exists("categories", $data)) {
            $post->categories()->attach($data["categories"]);
        }

        return redirect()->route('admin.show', $post->id);
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        $posts = Post::all();

        return view("admin.show", compact('post', 'posts'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        $categories = Category::all();
        // $this->authorize('update', $post);

        return view("admin.edit", compact('post', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePostRequest $request, Post $post)
    {
        $data = $request->validated();
        $post->update($data);

        // carico il file solo se ne ricevo uno
        if (key_exists("image", $data)) {
            // salvo in una variabile temporanea il percorso del nuovo file
            $path = Storage::put("posts", $data["image"]);
            // Dopo aver caricato la nuova immagine, prima di aggiornare il db,
            // cancelliamo dallo storage il vecchio file.
            Storage::delete($post->image);

            $post->image = $path;
        }

        $post->visibility = $request->has('visibility');
        $post->save();

        $post->categories()->sync($data['categories']);

        return redirect()->route('admin.show', $post->id);
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

        return redirect()->route('admin.dashboard');
    }
}
