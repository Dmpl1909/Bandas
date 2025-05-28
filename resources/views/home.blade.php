@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h1 class="mb-4">Bandas Disponíveis</h1>

    <div class="row">
        @foreach($bands as $band)
        <div class="col-md-3 mb-4">
            <div class="card">
                <img src="{{ asset($band->photo_path) }}"
                     class="card-img-top"
                     alt="{{ $band->name }}"
                     style="height: 120px; object-fit: cover;">
                <div class="card-body">
                    <h5 class="card-title">{{ $band->name }}</h5>
                    <p class="card-text">{{ $band->albums_count }} álbuns</p>
                    <a href="{{ route('bands.show', $band) }}" class="btn btn-sm btn-primary">
                        Ver Detalhes
                    </a>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <div class="text-center mt-4">
        <a href="{{ route('bands.index') }}" class="btn btn-outline-primary">
            Ver Todas as Bandas
        </a>
    </div>
</div>
@endsection
