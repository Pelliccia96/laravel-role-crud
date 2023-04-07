<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $users = User::all();
        $posts = Post::all();
        $categories = Category::all();

        return view("dashboard", compact('users', 'posts', 'categories'));
    }
}
