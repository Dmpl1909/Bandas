@extends('layouts.app')

@section('title', 'Adicionar Álbum')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">
                        <i class="fas fa-compact-disc me-2"></i>
                        Novo Álbum para {{ $band->name }}
                    </h4>
                </div>

                <div class="card-body">
                    <form action="{{ route('bands.albums.store', $band) }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <input type="hidden" name="band_id" value="{{ $band->id }}">

                        <div class="mb-3">
                            <label for="title" class="form-label">Título do Álbum *</label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror"
                                   id="title" name="title" value="{{ old('title') }}" required>
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="cover" class="form-label">Capa do Álbum *</label>
                            <input type="file" class="form-control @error('cover') is-invalid @enderror"
                                   id="cover" name="cover" required accept="image/*">
                            @error('cover')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Formatos: JPEG, PNG (Max: 2MB)</small>
                        </div>

                        <div class="mb-3">
                            <label for="release_date" class="form-label">Data de Lançamento *</label>
                            <input type="date" class="form-control @error('release_date') is-invalid @enderror"
                                   id="release_date" name="release_date" value="{{ old('release_date') }}" required>
                            @error('release_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('bands.show', $band) }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left me-1"></i> Voltar
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-1"></i> Salvar Álbum
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
