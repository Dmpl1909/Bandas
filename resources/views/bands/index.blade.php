@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Bandas</h1>
@auth
            @if(auth()->user()->isEditor())
<a href="{{ route('bands.create') }}" class="btn btn-primary">Adicionar Banda</a>

            @endif
        @endauth

    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="row">
        @forelse($bands as $band)
            <div class="col-md-4 mb-4">
                <div class="card h-100">
                    <img src="{{ asset($band->photo_path) }}" class="card-img-top" alt="{{ $band->name }}" style="height: 200px; object-fit: cover;">
                    <div class="card-body">
                        <h5 class="card-title">{{ $band->name }}</h5>
                        <p class="card-text">{{ $band->albums_count }} álbuns</p>
                        <p class="card-text text-truncate">{{ $band->description }}</p>
                    </div>
                    <div class="card-footer bg-white">
                        <a href="{{ route('bands.show', $band) }}" class="btn btn-sm btn-info">
                            <i class="fas fa-eye"></i> Ver
                        </a>
                        @auth
                            @if(auth()->user()->isEditor())
                                <a href="{{ route('bands.edit', $band) }}" class="btn btn-sm btn-warning">
                                    <i class="fas fa-edit"></i> Editar
                                </a>
                                <form action="{{ route('bands.destroy', $band) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Tem certeza que deseja excluir esta banda?')">
                                        <i class="fas fa-trash"></i> Excluir
                                    </button>
                                </form>
                            @endif
                        @endauth
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-info">
                    Nenhuma banda cadastrada.
                </div>
            </div>
        @endforelse
    </div>
</div>
@endsection
