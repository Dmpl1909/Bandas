@extends('layouts.app')

@section('title', $band->name)

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-4">
            <img src="{{ asset($band->photo_path) }}" class="img-fluid rounded" alt="{{ $band->name }}">
        </div>
        <div class="col-md-8">
            <h1>{{ $band->name }}</h1>

            @if($band->description)
                <p class="lead">{{ $band->description }}</p>
            @endif

            <h3 class="mt-4">Álbuns ({{ $band->albums_count }})</h3>



            <div class="mt-4">
                <a href="{{ route('bands.index') }}" class="btn btn-secondary">
                    Voltar para Bandas
                </a>

                @auth
                    @if(auth()->user()->isEditor())
                        <a href="{{ route('bands.edit', $band) }}" class="btn btn-warning">
                            Editar Banda
                        </a>
                    @endif
                @endauth
            </div>
        </div>
    </div>
</div>
@endsection
