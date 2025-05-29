<?php

namespace App\Http\Controllers;

use App\Models\Band;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BandController extends Controller
{
    // Método show() para exibir detalhes de uma banda
    public function show(Band $band)
    {
        // Carrega os álbuns relacionados
        $band->load('albums');

        return view('bands.show', compact('band'));
    }

    // Outros métodos do controller (index, create, store, edit, update, destroy)
    public function index()
    {
        $bands = Band::withCount('albums')->latest()->get();
        return view('bands.index', compact('bands'));
    }

    public function create()
    {
        return view('bands.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'photo' => 'required|image|mimes:jpeg,png,jpg',
            'description' => 'nullable|string',
        ]);

        $path = $request->file('photo')->store('public/bands');
        $validated['photo_path'] = str_replace('public/', 'storage/', $path);

        Band::create($validated);

        return redirect()->route('bands.index')->with('success', 'Banda criada com sucesso!');
    }

    public function edit(Band $band)
    {
        return view('bands.edit', compact('band'));
    }

    public function update(Request $request, Band $band)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg',
            'description' => 'nullable|string',
        ]);

        if ($request->hasFile('photo')) {
            // Remove a foto antiga
            Storage::delete(str_replace('storage/', 'public/', $band->photo_path));

            $path = $request->file('photo')->store('public/bands');
            $validated['photo_path'] = str_replace('public/', 'storage/', $path);
        }

        $band->update($validated);

        return redirect()->route('bands.index')->with('success', 'Banda atualizada com sucesso!');
    }

    public function destroy(Band $band)
    {
        if ($band->photo_path) {
            Storage::delete(str_replace('storage/', 'public/', $band->photo_path));
        }

        $band->delete();
        return redirect()->route('bands.index')->with('success', 'Banda excluída com sucesso!');
    }
}
