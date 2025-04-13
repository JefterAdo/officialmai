<?php

namespace App\Filament\Resources;

use App\Filament\Resources\NewsletterCampaignResource\Pages;
use App\Models\NewsletterCampaign;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class NewsletterCampaignResource extends Resource
{
    protected static ?string $model = NewsletterCampaign::class;

    protected static ?string $navigationIcon = 'heroicon-o-envelope';

    protected static ?string $navigationGroup = 'Communication';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('subject')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Select::make('template_id')
                    ->relationship('template', 'name')
                    ->searchable()
                    ->preload(),
                Forms\Components\RichEditor::make('content')
                    ->required()
                    ->columnSpanFull(),
                Forms\Components\DateTimePicker::make('scheduled_at'),
                Forms\Components\KeyValue::make('metadata')
                    ->columnSpanFull(),
                Forms\Components\Section::make('Statistiques')
                    ->schema([
                        Forms\Components\TextInput::make('total_recipients')
                            ->numeric()
                            ->disabled(),
                        Forms\Components\TextInput::make('successful_deliveries')
                            ->numeric()
                            ->disabled(),
                        Forms\Components\TextInput::make('failed_deliveries')
                            ->numeric()
                            ->disabled(),
                        Forms\Components\TextInput::make('opens')
                            ->numeric()
                            ->disabled(),
                        Forms\Components\TextInput::make('clicks')
                            ->numeric()
                            ->disabled(),
                    ])
                    ->columns(5)
                    ->visible(fn ($record) => $record && $record->sent_at !== null),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('subject')
                    ->searchable(),
                Tables\Columns\TextColumn::make('template.name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('scheduled_at')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('sent_at')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('total_recipients')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('successful_deliveries')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('opens')
                    ->numeric()
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'pending' => 'En attente',
                        'scheduled' => 'Programmée',
                        'sent' => 'Envoyée',
                    ])
                    ->query(function ($query, $data) {
                        if ($data['value'] === 'pending') {
                            return $query->pending();
                        }
                        if ($data['value'] === 'scheduled') {
                            return $query->scheduled();
                        }
                        if ($data['value'] === 'sent') {
                            return $query->sent();
                        }
                    }),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\Action::make('send')
                    ->icon('heroicon-o-paper-airplane')
                    ->requiresConfirmation()
                    ->visible(fn ($record) => $record->sent_at === null)
                    ->action(fn ($record) => $record->send()),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListNewsletterCampaigns::route('/'),
            'create' => Pages\CreateNewsletterCampaign::route('/create'),
            'edit' => Pages\EditNewsletterCampaign::route('/{record}/edit'),
        ];
    }
} 