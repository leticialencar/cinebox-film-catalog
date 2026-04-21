<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use Illuminate\Support\Facades\Http;

class HomeController extends Controller
{
    public function index()
    {
        $movies = Movie::latest()->get();

        $response = Http::get('https://api.themoviedb.org/3/movie/popular', [
            'api_key' => env('TMDB_API_KEY'),
            'language' => 'pt-BR'
        ]);

        $popular = $response->successful()
            ? $response->json()['results']
            : [];

        return view('dashboard', compact('movies', 'popular'));
    }
}