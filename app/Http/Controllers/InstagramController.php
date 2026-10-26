<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;

class InstagramController extends Controller
{

    //LEGADO RECEBIMENTO JSON DO PERFIL DO INSTAGRAM
    public function getMedia()
    {
        $token = config('services.instagram.token');
        $userId = config('services.instagram.user_id');

        $url = "https://graph.instagram.com/{$userId}/media";

        $response = Http::get($url, [
            'fields' => 'id,caption,media_type,media_url,thumbnail_url,permalink',
            'access_token' => $token,
        ]);
    
        $instagramData = $response->json();

        $instagram = $instagramData['data'] ?? [];

        return view('instagram.instagram', compact('instagram'));

        // return $response->json();
    }

}
