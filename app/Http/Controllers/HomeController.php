<?php

namespace App\Http\Controllers;

use App\Models\Band;
use App\Models\Album;

class HomeController extends Controller
{
    public function index()
    {
        // Bandas com mais álbuns (mais populares)
        $popularBands = Band::withCount('albums')
            ->orderBy('albums_count', 'desc')
            ->take(6)
            ->get();

        // Álbuns mais recentes
        $recentAlbums = Album::with('band')
            ->latest('release_date')
            ->take(8)
            ->get();

        // Todas as bandas para a listagem completa
        $allBands = Band::withCount('albums')
            ->orderBy('name')
            ->get();

            $bands = Band::all();

        return view('home', compact('popularBands', 'recentAlbums', 'allBands','bands'));
    }
}
