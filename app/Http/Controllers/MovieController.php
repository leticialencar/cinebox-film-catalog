<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;

class MovieController extends Controller
{
    public function index()
    {
        $userId = Auth::id();

        $movies = Movie::where('user_id', $userId)
            ->latest()
            ->get();

        $apiKey = config('services.tmdb.key');

        $popularResponse = Http::get('https://api.themoviedb.org/3/movie/popular', [
            'api_key' => $apiKey,
            'language' => 'pt-BR'
        ]);

        $popular = $popularResponse->successful()
            ? ($popularResponse->json()['results'] ?? [])
            : [];

        $topRatedResponse = Http::get('https://api.themoviedb.org/3/movie/top_rated', [
            'api_key' => $apiKey,
            'language' => 'pt-BR'
        ]);

        $topRated = $topRatedResponse->successful()
            ? ($topRatedResponse->json()['results'] ?? [])
            : [];

        return view('movies.index', compact('movies', 'popular', 'topRated'));
    }

    public function storeFromApi(Request $request)
    {
        $data = $request->validate([
            'tmdb_id'      => 'required',
            'title'        => 'required|string|max:255',
            'release_year' => 'nullable|integer',
            'description'  => 'nullable|string',
            'poster'       => 'nullable|string',
            'rating'       => 'nullable|numeric|min:0|max:10'
        ]);

        $userId = Auth::id();

        $exists = Movie::where('user_id', $userId)
            ->where('tmdb_id', $data['tmdb_id'])
            ->exists();

        if ($exists) {
            return redirect()
                ->route('movies.index')
                ->with('success', 'Esse filme já está na sua coleção!');
        }

        Movie::create([
            ...$data,
            'user_id' => $userId,
        ]);

        return redirect()
            ->route('movies.index')
            ->with('success', 'Filme adicionado com sucesso!');
    }
}