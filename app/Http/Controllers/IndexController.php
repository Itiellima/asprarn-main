<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;

class IndexController extends Controller
{
    public function index()
    {

        // 3 posts mais recentes
        $recentPosts = Post::latest()->take(3)->get();

        // Todos os posts ordenados
        $allPosts = Post::latest()->get();

        // Post mais recente
        $latestPost = Post::latest()->first();


        return view('welcome', compact('latestPost', 'allPosts', 'recentPosts'));
    }
}
