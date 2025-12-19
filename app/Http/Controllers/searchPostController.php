<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;

class searchPostController extends Controller
{
    public function index(Request $request)
    {

        $search = $request->input('search');
        
        $posts = Post::query()
            ->when($search, function ($query, $search) {
                $query->where(function ($query) use ($search) {
                    $query->where('titulo', 'like', "%{$search}%")
                            ->orWhere('texto', 'like', "%{$search}%")
                            ->orWhere('assunto', 'like', "%{$search}%");
                });
            })
            ->latest()
            ->paginate(10);

        return view('posts.search', compact('posts'));
    }
}
