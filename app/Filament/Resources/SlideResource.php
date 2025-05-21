<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SlideResource\Pages;
use App\Filament\Resources\SlideResource\RelationManagers;
use App\Models\Slide;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SlideResource extends Resource
{
    protected static ?string $model = Slide::class;

    protected static ?string $navigationIcon = 'heroicon-o-photo'; // Changé pour une icône plus appropriée
    protected static ?string $navigationGroup = 'Content Management'; // Pour grouper dans la navigation
    protected static ?int $navigationSort = 1; // Pour l'ordre dans le groupe

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title')
                    ->required()
                    ->maxLength(255)
                    ->columnSpanFull(), // Pour prendre toute la largeur
                Forms\Components\FileUpload::make('image_path')
                    ->label('Image')
                    ->image()
                    ->disk('public') // Utiliser le disque public
                    ->directory('slides') // Stocker dans storage/app/public/slides
                    ->visibility('public') // Rendre les fichiers uploadés publics
                    ->required()
                    ->columnSpanFull(),
                Forms\Components\Textarea::make('description')
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('button_text')
                    ->label('Button Text (Optional)')
                    ->maxLength(255),
                Forms\Components\TextInput::make('button_link')
                    ->label('Button Link (Optional)')
                    ->url() // Valider comme une URL
                    ->nullable() // Ajout pour le rendre vraiment optionnel
                    ->maxLength(255),
                Forms\Components\TextInput::make('order')
                    ->required()
                    ->numeric()
                    ->default(0)
                    ->helperText('Order of appearance in the slider (0 first).'),
                Forms\Components\Toggle::make('is_active')
                    ->required()
                    ->default(true)
                    ->label('Active'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('image_path') // Utilise par défaut le chemin, ou l'accesseur si disponible
                    ->label('Image')
                    ->disk('public') // Indiquer le disque pour la génération d'URL si nécessaire
                    ->width(100) // Ajuster la largeur
                    ->height('auto'), // Ajuster la hauteur
                Tables\Columns\TextColumn::make('title')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('order')
                    ->numeric()
                    ->sortable()
                    ->alignCenter(), // Centrer le contenu
                Tables\Columns\IconColumn::make('is_active')
                    ->label('Status')
                    ->boolean()
                    ->sortable(),
                Tables\Columns\TextColumn::make('button_text')
                    ->label('Button')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true), // Cacher par défaut
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
                // Peut-être un filtre pour 'is_active'
                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('Status')
                    ->trueLabel('Active Slides')
                    ->falseLabel('Inactive Slides')
                    ->placeholder('All Slides'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(), // Ajout de l'action de suppression individuelle
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('order', 'asc'); // Trier par défaut par le champ 'order'
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
            'index' => Pages\ListSlides::route('/'),
            'create' => Pages\CreateSlide::route('/create'),
            'edit' => Pages\EditSlide::route('/{record}/edit'),
        ];
    }
}
