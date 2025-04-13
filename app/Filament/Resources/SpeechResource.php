<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SpeechResource\Pages;
use App\Models\Speech;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SpeechResource extends Resource
{
    protected static ?string $model = Speech::class;

    protected static ?string $navigationIcon = 'heroicon-o-microphone';

    protected static ?string $navigationGroup = 'Médiathèque';

    protected static ?string $navigationLabel = 'Discours';

    protected static ?int $navigationSort = 3;

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

                        Forms\Components\TextInput::make('speaker')
                            ->required()
                            ->label('Orateur'),

                        Forms\Components\DatePicker::make('speech_date')
                            ->required()
                            ->label('Date du discours'),

                        Forms\Components\TextInput::make('location')
                            ->label('Lieu'),

                        Forms\Components\Textarea::make('excerpt')
                            ->label('Extrait')
                            ->rows(3),

                        Forms\Components\RichEditor::make('content')
                            ->columnSpanFull()
                            ->label('Contenu'),

                        Forms\Components\FileUpload::make('file_path')
                            ->directory('speeches')
                            ->acceptedFileTypes(['application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'])
                            ->maxSize(10240)
                            ->afterStateUpdated(function ($state, Forms\Set $set) {
                                if ($state) {
                                    $extension = pathinfo($state, PATHINFO_EXTENSION);
                                    $set('file_type', $extension);
                                    $set('file_size', filesize(storage_path('app/public/' . $state)));
                                }
                            })
                            ->label('Fichier (PDF, DOCX)'),

                        Forms\Components\TextInput::make('video_url')
                            ->url()
                            ->label('URL de la vidéo (YouTube)'),

                        Forms\Components\TextInput::make('audio_url')
                            ->url()
                            ->label('URL de l\'audio'),

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

                Tables\Columns\TextColumn::make('speaker')
                    ->searchable()
                    ->sortable()
                    ->label('Orateur'),

                Tables\Columns\TextColumn::make('speech_date')
                    ->date()
                    ->sortable()
                    ->label('Date du discours'),

                Tables\Columns\IconColumn::make('is_published')
                    ->boolean()
                    ->sortable()
                    ->label('Publié'),

                Tables\Columns\TextColumn::make('published_at')
                    ->dateTime()
                    ->sortable()
                    ->label('Date de publication'),
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
            'index' => Pages\ListSpeeches::route('/'),
            'create' => Pages\CreateSpeech::route('/create'),
            'edit' => Pages\EditSpeech::route('/{record}/edit'),
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