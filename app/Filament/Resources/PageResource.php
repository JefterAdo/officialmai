<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PageResource\Pages;
use App\Filament\Resources\PageResource\RelationManagers;
use App\Models\Page;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Str;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;

class PageResource extends Resource
{
    protected static ?string $model = Page::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static ?string $navigationGroup = 'Contenu';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Tabs::make('Page')
                    ->tabs([
                        Forms\Components\Tabs\Tab::make('Contenu Principal')
                            ->schema([
                                Forms\Components\TextInput::make('title')
                                    ->required()
                                    ->live(onBlur: true)
                                    ->afterStateUpdated(function (string $operation, $state, Forms\Set $set) {
                                        if ($operation === 'create') {
                                            $set('slug', Str::slug($state));
                                        }
                                    }),
                                Forms\Components\TextInput::make('slug')
                                    ->required()
                                    ->unique(ignoreRecord: true),
                                Forms\Components\RichEditor::make('content')
                                    ->required()
                                    ->columnSpanFull(),
                                Forms\Components\FileUpload::make('featured_image')
                                    ->image()
                                    ->directory('pages')
                                    ->columnSpanFull(),
                            ]),
                        Forms\Components\Tabs\Tab::make('SEO & Métadonnées')
                            ->schema([
                                Forms\Components\TextInput::make('meta_title')
                                    ->maxLength(60),
                                Forms\Components\Textarea::make('meta_description')
                                    ->maxLength(160),
                            ]),
                        Forms\Components\Tabs\Tab::make('Paramètres')
                            ->schema([
                                Forms\Components\Toggle::make('is_published')
                                    ->default(true),
                                Forms\Components\Select::make('layout')
                                    ->options([
                                        'default' => 'Par défaut',
                                        'full-width' => 'Pleine largeur',
                                        'sidebar' => 'Avec sidebar',
                                    ])
                                    ->default('default'),
                                Forms\Components\Select::make('template')
                                    ->options([
                                        'default' => 'Template par défaut',
                                        'welcome' => 'Page d\'accueil',
                                        'president.presentation' => 'Présentation du Président',
                                        'president.discours' => 'Discours du Président',
                                        'houphouet.biographie' => 'Biographie Houphouët',
                                        'houphouet.chronologie' => 'Chronologie Houphouët',
                                        'houphouet.discours' => 'Discours Houphouët',
                                        'parti.vision' => 'Vision du Parti',
                                        'parti.organisation' => 'Organisation du Parti',
                                        'parti.decouvrir' => 'Découvrir le Parti',
                                        'militer.adhesion' => 'Adhésion',
                                        'militer.propositions' => 'Propositions',
                                        'mediatheque.photos' => 'Galerie Photos',
                                        'mediatheque.videos' => 'Vidéothèque',
                                        'mediatheque.audio' => 'Audiothèque',
                                        'mediatheque.discours' => 'Discours',
                                    ])
                                    ->default('default'),
                                Forms\Components\Select::make('category')
                                    ->options([
                                        'president' => 'Le Président',
                                        'houphouet' => 'Houphouët-Boigny',
                                        'parti' => 'Le Parti',
                                        'militer' => 'Militer',
                                        'mediatheque' => 'Médiathèque',
                                        'actualites' => 'Actualités',
                                    ])
                                    ->nullable(),
                                Forms\Components\Select::make('parent_id')
                                    ->label('Page parente')
                                    ->options(fn () => Page::all()->pluck('title', 'id'))
                                    ->searchable(),
                                Forms\Components\TextInput::make('order')
                                    ->numeric()
                                    ->default(0),
                            ]),
                    ])
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('slug')
                    ->searchable(),
                Tables\Columns\TextColumn::make('category')
                    ->searchable(),
                Tables\Columns\TextColumn::make('template')
                    ->searchable(),
                Tables\Columns\IconColumn::make('is_published')
                    ->boolean(),
                Tables\Columns\TextColumn::make('layout'),
                Tables\Columns\TextColumn::make('parent.title')
                    ->label('Page parente'),
                Tables\Columns\TextColumn::make('order')
                    ->sortable(),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('layout')
                    ->options([
                        'default' => 'Par défaut',
                        'full-width' => 'Pleine largeur',
                        'sidebar' => 'Avec sidebar',
                    ]),
                Tables\Filters\SelectFilter::make('template')
                    ->options([
                        'default' => 'Template par défaut',
                        'welcome' => 'Page d\'accueil',
                        'president.presentation' => 'Présentation du Président',
                        'president.discours' => 'Discours du Président',
                        'houphouet.biographie' => 'Biographie Houphouët',
                        'houphouet.chronologie' => 'Chronologie Houphouët',
                        'houphouet.discours' => 'Discours Houphouët',
                        'parti.vision' => 'Vision du Parti',
                        'parti.organisation' => 'Organisation du Parti',
                        'parti.decouvrir' => 'Découvrir le Parti',
                        'militer.adhesion' => 'Adhésion',
                        'militer.propositions' => 'Propositions',
                        'mediatheque.photos' => 'Galerie Photos',
                        'mediatheque.videos' => 'Vidéothèque',
                        'mediatheque.audio' => 'Audiothèque',
                        'mediatheque.discours' => 'Discours',
                    ]),
                Tables\Filters\SelectFilter::make('category')
                    ->options([
                        'president' => 'Le Président',
                        'houphouet' => 'Houphouët-Boigny',
                        'parti' => 'Le Parti',
                        'militer' => 'Militer',
                        'mediatheque' => 'Médiathèque',
                        'actualites' => 'Actualités',
                    ]),
                Tables\Filters\TernaryFilter::make('is_published'),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->reorderable('order')
            ->defaultSort('order');
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPages::route('/'),
            'create' => Pages\CreatePage::route('/create'),
            'edit' => Pages\EditPage::route('/{record}/edit'),
        ];
    }
}
