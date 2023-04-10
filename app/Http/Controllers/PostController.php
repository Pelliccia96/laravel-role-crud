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
        /* $users = User::all();
        return view("dashboard", compact('users')); */
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
        // validated() usa le regole indicate nella funzione rules dello StorePostRequest e ci ritorna i dati validati
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

        $post->user_id = $user->id;
        $post->save();

        // Controlla che nei dati che il server sta ricevendo, ci sia un valore per la chiave "categories".
        if ($request->has("categories")) {
            // if (key_exists("categories", $data)) {
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
        return view("posts.show", compact('post', 'posts'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        // $post = Post::findOrFail($id);

        // dd($post->categories);
        $categories = Category::all();
        // $this->authorize('update', $post);

        return view("posts.edit", compact('post', 'categories'));
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
