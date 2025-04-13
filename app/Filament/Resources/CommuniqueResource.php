<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CommuniqueResource\Pages;
use App\Models\Communique;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CommuniqueResource extends Resource
{
    protected static ?string $model = Communique::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static ?string $navigationGroup = 'Actualités';

    protected static ?string $navigationLabel = 'Communiqués';

    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make()
                    ->schema([
                        Forms\Components\TextInput::make('title')
                            ->required()
                            ->live(onBlur: true)
                            ->afterStateUpdated(function (string $operation, $state, Forms\Set $set) {
                                if ($operation === 'create') {
                                    $set('slug', Str::slug($state));
                                }
                            })
                            ->label('Titre'),

                        Forms\Components\TextInput::make('slug')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->label('Slug'),

                        Forms\Components\RichEditor::make('content')
                            ->columnSpanFull()
                            ->fileAttachmentsDisk('public')
                            ->fileAttachmentsDirectory('communiques/images')
                            ->toolbarButtons([
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
                                'attachFiles',
                            ])
                            ->extraAttributes(['style' => 'min-height: 24rem;'])
                            ->label('Contenu'),

                        Forms\Components\FileUpload::make('file_path')
                            ->directory('communiques')
                            ->acceptedFileTypes(['application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'image/*'])
                            ->maxSize(10240)
                            ->afterStateUpdated(function ($state, Forms\Set $set) {
                                if ($state) {
                                    $extension = pathinfo($state, PATHINFO_EXTENSION);
                                    $set('file_type', $extension);
                                    $set('file_size', filesize(storage_path('app/public/' . $state)));
                                }
                            })
                            ->label('Fichier (PDF, DOCX, Images)'),

                        Forms\Components\Toggle::make('is_published')
                            ->label('Publié'),

                        Forms\Components\DateTimePicker::make('published_at')
                            ->label('Date de publication'),
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->searchable()
                    ->sortable()
                    ->label('Titre'),

                Tables\Columns\IconColumn::make('is_published')
                    ->boolean()
                    ->sortable()
                    ->label('Publié'),

                Tables\Columns\TextColumn::make('published_at')
                    ->dateTime()
                    ->sortable()
                    ->label('Date de publication'),

                Tables\Columns\TextColumn::make('file_type')
                    ->badge()
                    ->label('Type de fichier'),
            ])
            ->filters([
                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\ForceDeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make(),
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
            'index' => Pages\ListCommuniques::route('/'),
            'create' => Pages\CreateCommunique::route('/create'),
            'edit' => Pages\EditCommunique::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}