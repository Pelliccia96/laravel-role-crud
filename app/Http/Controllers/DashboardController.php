<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $users = User::all();
        $categories = Category::all();

        $posts = Post::where('user_id', auth()->id())->get();

        if(Auth::user()->role == 'super-admin' ? true : Auth::user()->role == 'admin') {
            $posts = Post::all();
        }

        return view("dashboard", compact('users', 'posts', 'categories'));
    }
}
