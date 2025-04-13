<div class="sidebar">
    <div class="card mb-4">
        <div class="card-header">
            <h5 class="card-title mb-0">Pages récentes</h5>
        </div>
        <div class="card-body">
            @php
                $recentPages = \App\Models\Page::published()
                    ->ordered()
                    ->limit(5)
                    ->get();
            @endphp
            
            <ul class="list-unstyled">
                @foreach($recentPages as $recentPage)
                    <li class="mb-2">
                        <a href="{{ $recentPage->url }}" class="text-decoration-none">
                            {{ $recentPage->title }}
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h5 class="card-title mb-0">Liens utiles</h5>
        </div>
        <div class="card-body">
            <ul class="list-unstyled">
                <li class="mb-2">
                    <a href="{{ route('actualites.index') }}" class="text-decoration-none">
                        Actualités
                    </a>
                </li>
                <li class="mb-2">
                    <a href="{{ route('contact') }}" class="text-decoration-none">
                        Contact
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div> 