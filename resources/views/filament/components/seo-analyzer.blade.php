<div class="p-4 space-y-4">
    <div class="flex items-center justify-between">
        <h3 class="text-lg font-medium">Analyse SEO</h3>
        {{ $getAction('analyze') }}
    </div>

    @if(isset($score) && isset($analysis))
        <div class="p-4 bg-white rounded-lg shadow">
            <div class="flex items-center justify-between mb-4">
                <span class="text-lg font-medium">Score SEO global</span>
                <span class="text-2xl font-bold {{ $score >= 80 ? 'text-green-600' : ($score >= 60 ? 'text-yellow-600' : 'text-red-600') }}">
                    {{ round($score) }}/100
                </span>
            </div>

            @foreach($analysis as $category => $data)
                <div class="mt-4 p-4 border rounded-lg">
                    <div class="flex items-center justify-between mb-2">
                        <h4 class="text-md font-medium">{{ str_replace('_', ' ', ucfirst($category)) }}</h4>
                        <span class="px-2 py-1 text-sm rounded {{ $data['score'] >= 80 ? 'bg-green-100 text-green-800' : ($data['score'] >= 60 ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                            Score: {{ $data['score'] }}/100
                        </span>
                    </div>

                    @if(!empty($data['recommendations']))
                        <ul class="mt-2 space-y-2">
                            @foreach($data['recommendations'] as $recommendation)
                                <li class="flex items-center justify-between">
                                    <span class="text-sm text-gray-600">{{ $recommendation }}</span>
                                    <button wire:click="applyRecommendation('{{ $category }}', '{{ $recommendation }}')" 
                                            class="px-2 py-1 text-xs text-primary-600 hover:text-primary-800">
                                        Appliquer
                                    </button>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            @endforeach
        </div>
    @endif

    <div x-data="{ showHelp: false }" class="mt-4">
        <button @click="showHelp = !showHelp" class="text-sm text-gray-600 hover:text-gray-800">
            Aide SEO
        </button>

        <div x-show="showHelp" class="mt-2 p-4 bg-gray-50 rounded-lg">
            <h4 class="font-medium mb-2">Conseils pour un bon SEO :</h4>
            <ul class="list-disc list-inside text-sm text-gray-600 space-y-1">
                <li>Utilisez des mots-clés pertinents de manière naturelle</li>
                <li>Structurez votre contenu avec des titres (H1, H2, H3)</li>
                <li>Ajoutez des images avec des attributs alt descriptifs</li>
                <li>Créez des méta-descriptions attrayantes</li>
                <li>Incluez des liens internes et externes pertinents</li>
                <li>Optimisez pour la recherche vocale avec des questions-réponses</li>
            </ul>
        </div>
    </div>
</div> 