<?php

namespace App\Filament\Widgets;

use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Database\Eloquent\Builder;
use App\Models\News;
use App\Models\Event;

class LatestActivities extends BaseWidget
{
    protected static ?string $heading = 'Activités récentes';
    protected int|string|array $columnSpan = 'full';
    protected static ?int $sort = 2;

    public function table(Table $table): Table
    {
        return $table
            ->query(
                News::query()
                    ->select('id', 'title', 'created_at', 'updated_at')
                    ->latest()
                    ->limit(5)
                    ->union(
                        Event::query()
                            ->select('id', 'title', 'created_at', 'updated_at')
                            ->latest()
                            ->limit(5)
                    )
                    ->orderBy('created_at', 'desc')
            )
            ->columns([
                Tables\Columns\TextColumn::make('type')
                    ->label('Type')
                    ->formatStateUsing(fn ($record) => $record instanceof News ? 'Actualité' : 'Événement')
                    ->badge()
                    ->color(fn ($record) => $record instanceof News ? 'success' : 'warning'),
                
                Tables\Columns\TextColumn::make('title')
                    ->label('Titre')
                    ->searchable()
                    ->limit(50),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Date de création')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),

                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Dernière modification')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->paginated(false);
    }
} 