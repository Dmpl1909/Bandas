@extends('layouts.app')

@section('title', 'Álbuns de ' . ($band->name ?? 'Banda Desconhecida'))

@section('content')
<div class="container">
    @isset($band)
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Álbuns de {{ $band->name }}</h1>

        @auth
            @if(auth()->user()->isEditor())
 <a href="{{ route('bands.albums.create', $band) }}" class="btn btn-primary">
    <i class="fas fa-plus"></i> Adicionar Álbum
</a>
            @endif
        @endauth
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="row">
        @forelse($albums as $album)
            <div class="col-md-4 mb-4">
                <div class="card h-100">
                    @if($album->cover_path)
                        <img src="{{ asset($album->cover_path) }}" class="card-img-top" alt="{{ $album->title }}" style="height: 200px; object-fit: cover;">
                    @else
                        <div class="bg-secondary text-white d-flex align-items-center justify-content-center" style="height: 200px;">
                            <span>Sem capa</span>
                        </div>
                    @endif
                    <div class="card-body">
                        <h5 class="card-title">{{ $album->title }}</h5>
                        <p class="card-text">
                            <strong>Lançamento:</strong> {{ $album->release_date->format('d/m/Y') }}
                        </p>
                    </div>
                    <div class="card-footer bg-transparent">
                        <a href="{{ route('bands.albums.show', [$band, $album]) }}" class="btn btn-sm btn-info">
                            Detalhes
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-info">
                    Nenhum álbum cadastrado para esta banda.
                </div>
            </div>
        @endforelse
    </div>

    <a href="{{ route('bands.show', $band) }}" class="btn btn-secondary mt-3">
        Voltar para Banda
    </a>
    @else
        <div class="alert alert-danger">
            Banda não encontrada ou não especificada.
        </div>
    @endisset
</div>
@endsection
