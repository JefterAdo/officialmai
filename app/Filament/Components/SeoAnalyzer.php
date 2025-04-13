<?php

namespace App\Filament\Components;

use Filament\Forms\Components\Component;
use App\Services\SeoAiService;
use Livewire\Attributes\Reactive;
use Filament\Forms\Components\Actions\Action;

class SeoAnalyzer extends Component
{
    protected string $view = 'filament.components.seo-analyzer';

    #[Reactive]
    public $content = '';

    #[Reactive]
    public $title = '';

    #[Reactive]
    public $metaDescription = '';

    #[Reactive]
    public $analysis = [];

    #[Reactive]
    public $score = null;

    protected function setUp(): void
    {
        parent::setUp();

        $this->content = '';
        $this->title = '';
        $this->metaDescription = '';
        $this->analysis = [];
        $this->score = null;
    }

    public function getActions(): array
    {
        return [
            Action::make('analyze')
                ->label('Analyser')
                ->action(function () {
                    $seoService = app(SeoAiService::class);
                    $result = $seoService->analyzeSeo(
                        $this->content,
                        $this->title,
                        $this->metaDescription
                    );

                    if ($result['success']) {
                        $this->analysis = $result['structured_data'];
                        $this->score = $this->calculateOverallScore($result['structured_data']);
                        
                        $this->dispatch('seo-analysis-complete', [
                            'analysis' => $this->analysis,
                            'score' => $this->score
                        ]);
                    }
                }),
        ];
    }

    protected function calculateOverallScore($structuredData)
    {
        $scores = collect($structuredData)->pluck('score');
        return $scores->avg();
    }

    public function applyRecommendation($category, $recommendation)
    {
        $this->dispatch('apply-seo-recommendation', [
            'category' => $category,
            'recommendation' => $recommendation
        ]);
    }

    public static function make(): static
    {
        return new static();
    }