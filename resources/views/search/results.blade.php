@extends('layouts.app')

@section('title', 'Résultats de recherche pour "' . e($query) . '"')

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-lg-10 mx-auto">
            <h1 class="mb-4">
                Résultats de recherche pour : <span class="text-primary">"{{ e($query) }}"</span>
            </h1>

            @if($results->isEmpty())
                <div class="alert alert-warning" role="alert">
                    Aucun résultat trouvé pour votre recherche. Veuillez essayer avec d'autres mots-clés.
                </div>
            @else
                <p class="text-muted mb-4">{{ $results->count() }} résultat(s) trouvé(s).</p>

                <div class="list-group">
                    @foreach($results as $result)
                        <a href="{{ $result->url }}" class="list-group-item list-group-item-action flex-column align-items-start mb-3 border rounded shadow-sm">
                            <div class="d-flex w-100 justify-content-between">
                                <h5 class="mb-1 text-primary">{{ $result->title }}</h5>
                                <small class="text-muted">{{ $result->created_at->format('d/m/Y') }}</small>
                            </div>
                            <p class="mb-1">
                                {{ Str::limit(strip_tags($result->content), 200) }}
                            </p>
                            <small class="badge bg-secondary fw-normal">{{ $result->type }}</small>
                        </a>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
