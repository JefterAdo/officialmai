<?php

namespace App\Filament\Resources\CommuniqueResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Livewire\TemporaryUploadedFile;

class AttachmentsRelationManager extends RelationManager
{
    protected static string $relationship = 'attachments';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\FileUpload::make('file_path')
                    ->label('Fichier')
                    ->required()
                    ->directory('communiques/documents')
                    ->acceptedFileTypes([
                        'application/pdf',
                        'image/jpeg',
                        'image/png',
                        'image/gif',
                        'application/msword',
                        'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                    ])
                    ->maxSize(10240) // 10MB
                    ->helperText('Formats acceptés : PDF, JPG, PNG, GIF, DOC, DOCX. Taille max : 10MB')
                    ->downloadable()
                    ->openable()
                    ->preserveFilenames(),
                
                Forms\Components\TextInput::make('original_name')
                    ->label('Nom original du fichier')
                    ->required()
                    ->maxLength(255),
                    
                Forms\Components\Hidden::make('file_type'),
                Forms\Components\Hidden::make('size'),
                Forms\Components\Hidden::make('mime_type'),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('original_name')
            ->columns([
                Tables\Columns\TextColumn::make('original_name')
                    ->label('Nom du fichier')
                    ->searchable(),
                    
                Tables\Columns\TextColumn::make('file_type')
                    ->label('Type')
                    ->sortable(),
                    
                Tables\Columns\TextColumn::make('human_readable_size')
                    ->label('Taille')
                    ->sortable(),
                    
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Date d\'ajout')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                    ->mutateFormDataUsing(function (array $data): array {
                        $file = TemporaryUploadedFile::createFromLivewire($data['file_path']);
                        
                        $data['file_path'] = $file->store('communiques/documents', 'public');
                        $data['file_type'] = $file->getClientOriginalExtension();
                        $data['mime_type'] = $file->getMimeType();
                        $data['size'] = $file->getSize();
                        
                        return $data;
                    }),
            ])
            ->actions([
                Tables\Actions\Action::make('télécharger')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->url(fn ($record) => $record->full_url)
                    ->openUrlInNewTab(),
                    
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
