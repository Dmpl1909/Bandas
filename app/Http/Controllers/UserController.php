<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class UserController extends Controller
{

    public function index()
    {
        // Apenas superadmin pode listar usuários
        if (!auth()->user()->isSuperAdmin()) {
            abort(403, 'Acesso não autorizado.');
        }

        $users = User::all();
        return view('users.index', compact('users'));
    }


    public function create()
    {
        // Apenas superadmin pode criar usuários
        if (!auth()->user()->isSuperAdmin()) {
            abort(403, 'Acesso não autorizado.');
        }

        return view('users.create');
    }


    public function store(Request $request)
    {
        // Apenas superadmin pode criar usuários
        if (!auth()->user()->isSuperAdmin()) {
            abort(403, 'Acesso não autorizado.');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role' => 'required|in:superadmin,admin,editor,viewer',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        return redirect()->route('users.index')
            ->with('success', 'Usuário criado com sucesso!');
    }

    public function show(User $user)
    {
        // Apenas superadmin pode ver detalhes de usuários
        if (!auth()->user()->isSuperAdmin()) {
            abort(403, 'Acesso não autorizado.');
        }

        return view('users.show', compact('user'));
    }


    public function edit(User $user)
    {
        // Apenas superadmin pode editar usuários
        if (!auth()->user()->isSuperAdmin()) {
            abort(403, 'Acesso não autorizado.');
        }

        return view('users.edit', compact('user'));
    }


    public function update(Request $request, User $user)
    {
        // Apenas superadmin pode atualizar usuários
        if (!auth()->user()->isSuperAdmin()) {
            abort(403, 'Acesso não autorizado.');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,'.$user->id,
            'password' => ['nullable', 'confirmed', Rules\Password::defaults()],
            'role' => 'required|in:superadmin,admin,editor,viewer',
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return redirect()->route('users.index')
            ->with('success', 'Usuário atualizado com sucesso!');
    }


    public function destroy(User $user)
    {
        // Apenas superadmin pode deletar usuários
        if (!auth()->user()->isSuperAdmin()) {
            abort(403, 'Acesso não autorizado.');
        }

        // Não permitir que o superadmin atual se delete
        if ($user->id === auth()->id()) {
            return redirect()->route('users.index')
                ->with('error', 'Você não pode deletar a si mesmo!');
        }

        $user->delete();

        return redirect()->route('users.index')
            ->with('success', 'Usuário deletado com sucesso!');
    }
}
