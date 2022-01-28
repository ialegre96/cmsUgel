@extends('frontend.layouts.home_layout')
@section('title', 'Normatividad')
@section('content')
<div class="container mt-4 mb-4" id="buscador-filtro">
    <div class="col-md-6">

        <form class="d-flex mb-2">
            <p class="mt-3 pr-2" style="margin-right: 10px">Buscar</p> <input class="form-control me-2" type="Buscar"
                placeholder="Buscar en documentos" aria-label="Buscar">
        </form>
        <p>100 resultados encontrados</p>
    </div>
</div>

<!-- Page content-->
<div class="container">
    <div class="row">
        <!-- Filtros-->
        <div class="col-lg-3">
            <h3>Filtrar por:</h3>
            <hr>
            <!-- Search widget-->
            <div class="mb-4">
                <form class="needs-validation" novalidate>
                    <div class="col-md-12 mb-3">
                        <label for="country" class="form-label">Tipo de documento</label>
                        <select class="form-select" id="country" required="">
                            <option value="">Documentos generales</option>
                            <option>Normas, directivas y resoluciones</option>
                            <option>Oficios,otros</option>
                            <option>Área de tesosería</option>
                            <option>Otras áreas</option>
                        </select>
                    </div>

                    <div class="col-md-12 mb-3">
                        <label for="country" class="form-label">Fecha desde</label>
                        <input type="date">
                    </div>

                    <div class="col-md-12 mb-3">
                        <label for="country" class="form-label">Hasta</label>
                        <input type="date">
                    </div>

                    <a class="btn btn-primary w-100 mt-2" href="#!">Aplicar</a>
            </div>
        </div>
        <!-- Derecha entradas-->
        <div id="resultado-filtro" class="col-lg-9">
            <h3>Documentos generales: Normatividad</h3>
            <hr>
            <div class="col-md-12 border p-3">
                @foreach ($regulations as $regulation)
                <div class="row g-0 rounded overflow-hidden flex-md-row h-md-250 position-relative">
                    <div class="col-auto d-none d-lg-block">
                        <img class="card-img-top" src="{{ $regulation->page_image }}" alt="...">

                    </div>
                    <div class="col p-4 d-flex flex-column position-static">

                        <h3 class="mb-0">{{ $regulation->title }}</h3>
                        <div class="mb-1 text-muted">{{ $regulation->created_at->format('d/m/Y') }}</div>
                        <p class="card-text mb-auto">{{ $regulation->description }}</p>
                        <a href="{{ $regulation->url_file }}" class="stretched-link"><i class="bi bi-app"></i>
                            Ver/Descargar&nbsp;&nbsp;<i class="fas fa-angle-right"></i></a>
                    </div>
                </div>
                <hr>
                @endforeach
            </div>
            <!-- Pagination-->
            <nav aria-label="Pagination">
                {{ $regulations->links('frontend.paginator') }}
            </nav>
        </div>

    </div>
</div>

@endsection
