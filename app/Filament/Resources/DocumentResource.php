<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DocumentResource\Pages;
use App\Filament\Resources\DocumentResource\RelationManagers;
use App\Models\Document;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Str;

class DocumentResource extends Resource
{
    protected static ?string $model = Document::class;

    protected static ?string $navigationIcon = 'heroicon-o-document';
    
    protected static ?string $navigationGroup = 'Contenu';
    
    protected static ?int $navigationSort = 4;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Placeholder::make('notice')
                    ->content('ℹ️ <span class="font-semibold">Rappel :</span> Seuls les documents créés ici, marqués comme <span class="text-green-600 font-semibold">actif</span>, seront affichés sur le site public. Vérifiez le type, le titre, et le statut avant de valider.')
                    ->extraAttributes(['class' => 'bg-orange-50 border-l-4 border-orange-400 text-orange-700 px-4 py-3 rounded mb-6 text-sm'])
                    ->columnSpanFull(),
                Forms\Components\Section::make('Informations du document')
                    ->schema([
                        Forms\Components\TextInput::make('title')
                            ->label('Titre')
                            ->required()
                            ->maxLength(255)
                            ->live(onBlur: true)
                            ->afterStateUpdated(function (string $operation, $state, Forms\Set $set) {
                                if ($operation === 'edit') return;
                                $set('slug', Str::slug($state));
                            }),
                        Forms\Components\TextInput::make('slug')
                            ->label('Slug (URL)')
                            ->required()
                            ->maxLength(255)
                            ->unique(ignoreRecord: true),
                        Forms\Components\Select::make('type')
                            ->label('Type de document')
                            ->options([
                                'statut' => 'Statut',
                                'reglement-interieur' => 'Règlement Intérieur',
                            ])
                            ->required(),
                        Forms\Components\FileUpload::make('file_path')
                            ->label('Fichier')
                            ->required()
                            ->preserveFilenames()
                            ->acceptedFileTypes(['application/pdf', 'application/x-pdf'])
                            ->maxSize(10240) // 10MB
                            ->directory('documents')
                            ->downloadable()
                            ->openable()
                            ->previewable(false)
                            ->helperText('Formats acceptés : PDF (max 10MB)'),
                        Forms\Components\Textarea::make('description')
                            ->label('Description')
                            ->columnSpanFull()
                            ->maxLength(500)
                            ->rows(3),
                        Forms\Components\Toggle::make('is_active')
                            ->label('Actif')
                            ->default(true)
                            ->required(),
                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->label('Titre')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('type')
                    ->label('Type')
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'statut' => 'Statut',
                        'reglement-interieur' => 'Règlement Intérieur',
                        default => $state,
                    })
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'statut' => 'primary',
                        'reglement-interieur' => 'success',
                        default => 'gray',
                    }),
                Tables\Columns\IconColumn::make('is_active')
                    ->label('Statut')
                    ->boolean()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Date de création')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('type')
                    ->label('Type de document')
                    ->options([
                        'statut' => 'Statut',
                        'reglement-interieur' => 'Règlement Intérieur',
                    ]),
                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('Statut')
                    ->boolean()
                    ->trueLabel('Actif')
                    ->falseLabel('Inactif'),
            ])
            ->actions([
                Tables\Actions\ViewAction::make()
                    ->url(fn (Document $record): string => route('filament.admin.resources.documents.view', $record)),
                Tables\Actions\EditAction::make(),
                Tables\Actions\Action::make('download')
                    ->label('')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->url(fn (Document $record): string => route('documents.download', $record->slug))
                    ->openUrlInNewTab(),
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
            'index' => Pages\ListDocuments::route('/'),
            'create' => Pages\CreateDocument::route('/create'),
            'view' => Pages\ViewDocument::route('/{record}'),
            'edit' => Pages\EditDocument::route('/{record}/edit'),
        ];
    }
    
    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }
}
