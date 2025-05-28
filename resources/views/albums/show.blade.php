@extends('layouts.app')

@section('title', $album->title . ' - ' . $band->name)

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-4">
            @if($album->cover_path)
                <img src="{{ asset($album->cover_path) }}" class="img-fluid rounded" alt="{{ $album->title }}">
            @else
                <div class="bg-secondary text-white d-flex align-items-center justify-content-center" style="height: 300px;">
                    <span>Sem capa</span>
                </div>
            @endif
        </div>
        <div class="col-md-8">
            <h1>{{ $album->title }}</h1>
            <h3 class="text-muted">{{ $band->name }}</h3>

            <ul class="list-group list-group-flush mb-4">
                <li class="list-group-item">
                    <strong>Data de Lançamento:</strong> {{ $album->release_date->format('d/m/Y') }}
                </li>
                <li class="list-group-item">
                    <strong>Banda:</strong>
                    <a href="{{ route('bands.show', $band) }}">{{ $band->name }}</a>
                </li>
            </ul>

            <div class="d-flex gap-2">
                <a href="{{ route('bands.albums.index', $band) }}" class="btn btn-secondary">
                    Voltar para Álbuns
                </a>

                @auth
                    @if(auth()->user()->isEditor())
                        <a href="{{ route('bands.albums.edit', [$band, $album]) }}" class="btn btn-warning">
                            Editar Álbum
                        </a>
                    @endif
                @endauth
            </div>
        </div>
    </div>
</div>
@endsection
