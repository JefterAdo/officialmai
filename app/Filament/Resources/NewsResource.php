<?php

namespace App\Filament\Resources;

use App\Filament\Resources\NewsResource\Pages;
use App\Filament\Resources\NewsResource\RelationManagers;
use App\Models\News;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Str;
use App\Filament\Components\SeoAnalyzer;

class NewsResource extends Resource
{
    protected static ?string $model = News::class;

    protected static ?string $navigationIcon = 'heroicon-o-newspaper';

    protected static ?string $navigationGroup = 'Gestion de Contenu';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Grid::make()
                ->schema([
                    Forms\Components\Group::make()
                        ->schema([
                            Forms\Components\TextInput::make('title')
                                ->required()
                                ->maxLength(255)
                                ->live(onBlur: true)
                                ->afterStateUpdated(function (string $operation, $state, Forms\Set $set) {
                                    if ($operation !== 'create') {
                                        return;
                                    }
                
                                    $set('slug', Str::slug($state));
                                }),
                
                            Forms\Components\TextInput::make('slug')
                                ->disabled()
                                ->dehydrated()
                                ->required()
                                ->maxLength(255)
                                ->unique(News::class, 'slug', ignoreRecord: true),
                
                            Forms\Components\Textarea::make('meta_description')
                                ->label('Meta Description (SEO)')
                                ->helperText('Généralement affichée dans les résultats de recherche. Idéalement entre 150-160 caractères.')
                                ->maxLength(160)
                                ->reactive()
                                ->afterStateUpdated(function ($state, callable $set, callable $get) {
                                    // Si l'utilisateur commence à saisir, on ne modifie plus automatiquement
                                    if (!empty($state)) {
                                        $set('meta_description', $state);
                                    } else {
                                        // Si le champ est vide, on génère une description à partir du contenu
                                        $content = strip_tags($get('content') ?? '');
                                        $set('meta_description', Str::limit($content, 160));
                                    }
                                })
                                ->columnSpanFull(),

                            Forms\Components\RichEditor::make('content')
                                ->required()
                                ->columnSpanFull()
                                ->fileAttachmentsDisk('public')
                                ->fileAttachmentsDirectory('images')
                                ->toolbarButtons([
                                    'attachFiles',
                                    'blockquote',
                                    'bold',
                                    'bulletList',
                                    'codeBlock',
                                    'h2',
                                    'h3',
                                    'italic',
                                    'link',
                                    'orderedList',
                                    'redo',
                                    'strike',
                                    'underline',
                                    'undo',
                                ])
                                ->afterStateUpdated(function ($state, callable $set, callable $get) {
                                    // Si le champ meta_description est vide, on le remplit avec un extrait du contenu
                                    if (empty($get('meta_description'))) {
                                        $set('meta_description', Str::limit(strip_tags($state), 160));
                                    }
                                })
                                ->extraAttributes(['style' => 'min-height: 20rem;']),
                
                            Forms\Components\Select::make('category_id')
                                ->relationship('category', 'name')
                                ->required(),
                
                            Forms\Components\Toggle::make('is_published')
                                ->required(),
                
                            Forms\Components\DateTimePicker::make('published_at')
                                ->required(),
                
                            Forms\Components\FileUpload::make('featured_image')
                                ->image()
                                ->directory('news/featured')
                                ->required(),
                        ])
                        ->columnSpan(['lg' => 2]),
                    
                    Forms\Components\Group::make()
                        ->schema([
                            SeoAnalyzer::make()
                                ->columnSpanFull()
                                ->reactive()
                                ->afterStateUpdated(function ($state, Forms\Set $set) {
                                    $set('meta_title', $state['title'] ?? '');
                                    $set('meta_description', $state['metaDescription'] ?? '');
                                }),
                        ])
                        ->columnSpan(['lg' => 1]),
                ])
                ->columns(3),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->searchable()
                    ->description(fn (News $record) => Str::limit($record->meta_description, 50))
                    ->wrap(),
                Tables\Columns\TextColumn::make('category.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\IconColumn::make('is_published')
                    ->boolean(),
                Tables\Columns\TextColumn::make('published_at')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('category')
                    ->relationship('category', 'name'),
                Tables\Filters\TernaryFilter::make('is_published'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
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
            'index' => Pages\ListNews::route('/'),
            'create' => Pages\CreateNews::route('/create'),
            'edit' => Pages\EditNews::route('/{record}/edit'),
        ];
    }
}