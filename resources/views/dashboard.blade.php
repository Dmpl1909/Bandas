@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h3 class="mb-0">
                        <i class="fas fa-tachometer-alt me-2"></i>Dashboard
                    </h3>
                </div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <div class="alert alert-success">
                        <h4 class="alert-heading">
                            <i class="fas fa-user me-2"></i>
                            Olá, {{ Auth::user()->name }}!
                        </h4>
                        <p class="mb-0">
                            Você está logado como <strong>{{ ucfirst(Auth::user()->role) }}</strong>.
                        </p>
                    </div>

                    <div class="row mt-4">
                        <div class="col-md-6 mb-4">
                            <div class="card border-0 shadow-sm h-100">
                                <div class="card-body text-center">
                                    <i class="fas fa-users fa-3x text-primary mb-3"></i>
                                    <h5>Total de Bandas</h5>
                                    <p class="display-6">{{ App\Models\Band::count() }}</p>
                                    <a href="{{ route('bands.index') }}" class="btn btn-outline-primary">
                                        Ver Bandas
                                    </a>
                                </div>
                            </div>
                        </div>


                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
