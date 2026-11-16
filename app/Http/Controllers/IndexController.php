<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use App\Models\Post;

class IndexController extends Controller
{
    public function index()
    {
        // Uma consulta só para os 9 posts mais recentes, já com as imagens (evita uma consulta por post)
        $posts = Post::with('files')->latest()->take(9)->get();

        // 6 primeiros no feed de notícias; 7º ao 9º na lateral, sem repetir os do feed
        $feedPosts = $posts->take(6);
        $recentPosts = $posts->slice(6)->values();

        // Banner sem imagem deixaria um slide em branco no carrossel
        $banners = Banner::with('files')->latest()->get()
            ->filter(fn ($banner) => $banner->files->isNotEmpty())
            ->values();

        return view('welcome', compact('feedPosts', 'recentPosts', 'banners'));
    }
}
