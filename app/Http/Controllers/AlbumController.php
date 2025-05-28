<?php

namespace App\Http\Controllers;

use App\Models\Band;
use App\Models\Album;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AlbumController extends Controller
{

public function index(Band $band)
{
    // Carrega os álbuns da banda específica ordenados por data
    $albums = $band->albums()->orderBy('release_date', 'desc')->get();

    return view('albums.index', [
        'band' => $band,
        'albums' => $albums
    ]);
}

    public function create(Band $band)
    {
        return view('albums.create', compact('band'));
    }


    public function store(Request $request, Band $band)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'cover' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'release_date' => 'required|date',
        ]);

        if ($request->hasFile('cover')) {
            $path = $request->file('cover')->store('public/albums');
            $validated['cover_path'] = str_replace('public/', 'storage/', $path);
        }

        $band->albums()->create($validated);
        $band->updateAlbumsCount();

        return redirect()->route('bands.albums.index', $band)
            ->with('success', 'Álbum criado com sucesso!');
    }


    public function show(Band $band, Album $album)
    {
        return view('albums.show', compact('band', 'album'));
    }

    public function edit(Band $band, Album $album)
    {
        return view('albums.edit', compact('band', 'album'));
    }


    public function update(Request $request, Band $band, Album $album)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'cover' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'release_date' => 'required|date',
        ]);

        if ($request->hasFile('cover')) {
            // Remove a imagem antiga se existir
            if ($album->cover_path) {
                Storage::delete(str_replace('storage/', 'public/', $album->cover_path));
            }

            $path = $request->file('cover')->store('public/albums');
            $validated['cover_path'] = str_replace('public/', 'storage/', $path);
        }

        $album->update($validated);

        return redirect()->route('bands.albums.index', $band)
            ->with('success', 'Álbum atualizado com sucesso!');
    }


    public function destroy(Band $band, Album $album)
    {
        if ($album->cover_path) {
            Storage::delete(str_replace('storage/', 'public/', $album->cover_path));
        }

        $album->delete();
        $band->updateAlbumsCount();

        return redirect()->route('bands.albums.index', $band)
            ->with('success', 'Álbum excluído com sucesso!');
    }
}
