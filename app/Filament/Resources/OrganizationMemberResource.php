<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OrganizationMemberResource\Pages;
use App\Filament\Resources\OrganizationMemberResource\RelationManagers;
use App\Models\OrganizationStructure;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class OrganizationMemberResource extends Resource
{
    protected static ?string $model = OrganizationStructure::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';
    protected static ?string $navigationGroup = 'Organisation';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('title')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('description')
                    ->maxLength(255),
                Forms\Components\FileUpload::make('image')
                    ->image()
                    ->disk('public')
                    ->directory('membres')
                    ->visibility('public')
                    ->imageEditor()
                    ->imageEditorAspectRatios([
                        '16:9',
                        '4:3',
                        '1:1',
                    ])
                    ->imageEditorMode(2)
                    ->columnSpanFull()
                    ->preserveFilenames()
                    ->maxSize(5120)
                    ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp'])
                    ->helperText('Format recommandé : JPEG, PNG ou WebP. Taille maximale : 5MB.')
                    ->imagePreviewHeight('250')
                    ->loadingIndicatorPosition('left')
                    ->panelAspectRatio('2:1')
                    ->panelLayout('integrated')
                    ->removeUploadedFileButtonPosition('right')
                    ->uploadButtonPosition('left')
                    ->uploadProgressIndicatorPosition('left')
                    ->nullable(),
                Forms\Components\Select::make('role')
                    ->options([
                        'president' => 'Président',
                        'vice_president' => 'Vice-Président',
                        'tresorier' => 'Trésorier',
                        'porte_parole' => 'Porte-Parole',
                        'porte_parole_adjoint' => 'Porte-Parole Adjoint',
                        'secretaire_executif' => 'Secrétaire Exécutif',
                        'membre' => 'Membre',
                    ])
                    ->required(),
                Forms\Components\Select::make('group')
                    ->options([
                        'directoire' => 'Directoire',
                        'secretariat_executif' => 'Secrétariat Exécutif',
                    ])
                    ->required(),
                Forms\Components\TextInput::make('order')
                    ->numeric()
                    ->default(0),
                Forms\Components\Toggle::make('is_active')
                    ->required()
                    ->default(true),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('title')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\ImageColumn::make('image')
                    ->disk('public')
                    ->size(100)
                    ->square()
                    ->defaultImageUrl(asset('images/default-member.jpg')),
                Tables\Columns\TextColumn::make('role')
                    ->searchable(),
                Tables\Columns\TextColumn::make('group')
                    ->searchable(),
                Tables\Columns\TextColumn::make('order')
                    ->sortable(),
                Tables\Columns\IconColumn::make('is_active')
                    ->boolean(),
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
                Tables\Filters\SelectFilter::make('role')
                    ->options([
                        'president' => 'Président',
                        'vice_president' => 'Vice-Président',
                        'tresorier' => 'Trésorier',
                        'porte_parole' => 'Porte-Parole',
                        'porte_parole_adjoint' => 'Porte-Parole Adjoint',
                        'secretaire_executif' => 'Secrétaire Exécutif',
                        'membre' => 'Membre',
                    ]),
                Tables\Filters\SelectFilter::make('group')
                    ->options([
                        'directoire' => 'Directoire',
                        'secretariat_executif' => 'Secrétariat Exécutif',
                    ]),
                Tables\Filters\TernaryFilter::make('is_active'),
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
            'index' => Pages\ListOrganizationMembers::route('/'),
            'create' => Pages\CreateOrganizationMember::route('/create'),
            'edit' => Pages\EditOrganizationMember::route('/{record}/edit'),
        ];
    }
}
