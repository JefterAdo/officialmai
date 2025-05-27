<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CommuniqueResource\Pages;
use App\Models\Communique;
use App\Models\CommuniqueAttachment;
use Filament\Forms;
use Filament\Forms\Form;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CommuniqueResource extends Resource
{
    protected static ?string $model = Communique::class;

    protected static ?string $navigationIcon = 'heroicon-o-megaphone';

    protected static ?string $navigationGroup = 'Médiathèque';

    protected static ?string $navigationLabel = 'Communiqués';

    protected static ?int $navigationSort = 1;

    protected static ?string $modelLabel = 'Communiqué';

    protected static ?string $pluralModelLabel = 'Communiqués';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informations du communiqué')
                    ->schema([
                        Forms\Components\TextInput::make('title')
                            ->required()
                            ->maxLength(255)
                            ->live(onBlur: true)
                            ->afterStateUpdated(function ($get, $set, ?string $state) {
                                if (!$get('id')) {
                                    $set('slug', Str::slug($state));
                                }
                            })
                            ->label('Titre du communiqué'),

                        Forms\Components\TextInput::make('slug')
                            ->required()
                            ->maxLength(255)
                            ->unique(ignoreRecord: true)
                            ->label('URL personnalisée'),

                        Forms\Components\RichEditor::make('content')
                            ->columnSpanFull()
                            ->fileAttachmentsDisk('public')
                            ->fileAttachmentsDirectory('communiques/attachments')
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
                            ->label('Contenu détaillé'),

                        // Section pour afficher les pièces jointes existantes
                        Forms\Components\Section::make('Pièces jointes existantes')
                            ->schema([
                                Forms\Components\Repeater::make('existing_attachments')
                                    ->label('')
                                    ->schema(function ($record) {
                                        $attachments = [];
                                        
                                        // Vérifier si l'enregistrement existe avant d'accéder à ses pièces jointes
                                        if ($record && $record->exists) {
                                            $attachments = $record->attachments->map(function ($attachment) {
                                                return [
                                                    'id' => $attachment->id,
                                                    'name' => $attachment->original_name,
                                                    'size' => $attachment->human_readable_size,
                                                    'url' => $attachment->full_url,
                                                ];
                                            })->toArray();
                                        }
                                        
                                        return [
                                            Forms\Components\View::make('filament.forms.components.attachments-list')
                                                ->viewData(['attachments' => $attachments])
                                        ];
                                    })
                                    ->itemLabel(fn (array $state): ?string => $state['name'] ?? null)
                                    ->hidden(fn ($record) => $record === null || $record->attachments->isEmpty())
                                    ->deletable(false)
                                    ->addable(false)
                                    ->collapsible()
                                    ->columns(1),
                            ])
                            ->hiddenOn('create'),
                            
                        // Section pour ajouter de nouvelles pièces jointes
                        Forms\Components\Fieldset::make('Ajouter des fichiers')
                            ->schema([
                                Forms\Components\FileUpload::make('attachments')
                                    ->label('')
                                    ->multiple()
                                    ->maxFiles(4)
                                    ->directory('communiques/documents')
                                    // Utiliser une validation personnalisée pour accepter les PDF et images
                                    ->acceptedFileTypes([
                                        'application/pdf',
                                        'image/jpeg',
                                        'image/png',
                                        'image/gif',
                                        'image/webp',
                                        'image/svg+xml',
                                        'application/msword',
                                        'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                                    ])
                                    // Ne pas appeler image() car cela écraserait les types acceptés
                                    ->downloadable()
                                    ->openable()
                                    ->maxSize(10240) // 10MB par fichier
                                    ->helperText('Formats acceptés : PDF, JPG, PNG, GIF, DOC, DOCX. Taille max : 10MB par fichier. Max 4 fichiers.')
                                    ->reorderable()
                                    ->appendFiles()
                                    ->preserveFilenames()
                                    ->saveUploadedFileUsing(function (TemporaryUploadedFile $file) {
                                        try {
                                            // Générer un nom de fichier sécurisé basé sur le nom original
                                            $originalName = $file->getClientOriginalName();
                                            $extension = $file->getClientOriginalExtension() ?: pathinfo($originalName, PATHINFO_EXTENSION);
                                            $cleanName = preg_replace('/[^\w\-\.]/', '_', pathinfo($originalName, PATHINFO_FILENAME));
                                            $secureName = $cleanName . '_' . uniqid() . '.' . $extension;
                                            
                                            // Déterminer le type MIME de façon sécurisée
                                            try {
                                                $mimeType = $file->getMimeType() ?: 'application/octet-stream';
                                            } catch (\Exception $e) {
                                                \Log::warning("Impossible de déterminer le type MIME, utilisation d'un type par défaut", [
                                                    'fichier' => $originalName, 
                                                    'erreur' => $e->getMessage()
                                                ]);
                                                $mimeType = 'application/octet-stream';
                                            }
                                            
                                            // Journaliser les informations sur le fichier
                                            \Log::info('Tentative de téléchargement de fichier', [
                                                'nom_original' => $originalName,
                                                'nom_sécurisé' => $secureName,
                                                'type' => $mimeType,
                                                'taille' => $file->getSize(),
                                            ]);
                                            
                                            // Obtenir le chemin temporaire local du fichier
                                            $tempPath = $file->getRealPath();
                                            
                                            if (!file_exists($tempPath)) {
                                                throw new \Exception("Le fichier temporaire n'existe pas: {$tempPath}");
                                            }
                                            
                                            // Stocker le fichier directement avec un nouveau nom
                                            $destinationPath = 'communiques/documents/' . $secureName;
                                            
                                            // Utiliser l'API directe de stockage plutôt que les méthodes du fichier temporaire
                                            $result = Storage::disk('public')->put($destinationPath, file_get_contents($tempPath));
                                            
                                            if (!$result) {
                                                throw new \Exception("Impossible d'enregistrer le fichier sur le disque");
                                            }
                                            
                                            // Vérifier si le fichier a été correctement enregistré
                                            if (!Storage::disk('public')->exists($destinationPath)) {
                                                throw new \Exception("Le fichier n'a pas pu être enregistré sur le disque");
                                            }
                                            
                                            \Log::info('Fichier téléchargé avec succès', [
                                                'nom_original' => $originalName,
                                                'chemin' => $destinationPath,
                                                'taille' => filesize($tempPath),
                                            ]);
                                            
                                            // Retourner le chemin complet (pas juste le nom original)
                                            return $destinationPath;
                                        } catch (\Exception $e) {
                                            \Log::error('Erreur lors du téléchargement du fichier', [
                                                'erreur' => $e->getMessage(),
                                                'fichier' => $file->getClientOriginalName() ?? 'inconnu',
                                                'trace' => $e->getTraceAsString(),
                                            ]);
                                            
                                            throw $e;
                                        }
                                    })
                            ])
                            ->columns(1),

                        Forms\Components\DateTimePicker::make('published_at')
                            ->label('Date de publication')
                            ->default(now())
                            ->required(),

                        Forms\Components\Toggle::make('is_published')
                            ->label('Publié')
                            ->default(true)
                            ->inline(false),
                    ])
                    ->columns(2)
                    ->columnSpan(['lg' => fn (?Communique $record) => $record === null ? 3 : 2]),

                Forms\Components\Section::make('Métadonnées')
                    ->schema([
                        Forms\Components\Placeholder::make('created_at')
                            ->label('Créé le')
                            ->content(fn (Communique $record): ?string => $record->created_at?->diffForHumans()),

                        Forms\Components\Placeholder::make('updated_at')
                            ->label('Modifié le')
                            ->content(fn (Communique $record): ?string => $record->updated_at?->diffForHumans()),

                        Forms\Components\Placeholder::make('download_count')
                            ->label('Téléchargements')
                            ->content(fn (Communique $record): string => number_format($record->download_count, 0, ',', ' ')),
                    ])
                    ->columnSpan(['lg' => 1])
                    ->hidden(fn (?Communique $record) => $record === null),
            ])
            ->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->searchable()
                    ->sortable()
                    ->label('Titre')
                    ->limit(50),

                Tables\Columns\TextColumn::make('published_at')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->label('Date de publication'),

                Tables\Columns\IconColumn::make('is_published')
                    ->boolean()
                    ->sortable()
                    ->label('Publié'),

                Tables\Columns\TextColumn::make('file_type')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => strtoupper($state))
                    ->color(fn (string $state): string => match ($state) {
                        'pdf' => 'danger',
                        'doc', 'docx' => 'primary',
                        'jpg', 'jpeg', 'png', 'gif' => 'success',
                        default => 'gray',
                    })
                    ->label('Type de fichier'),

                Tables\Columns\TextColumn::make('download_count')
                    ->numeric()
                    ->sortable()
                    ->label('Téléchargements'),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('is_published')
                    ->options([
                        '1' => 'Publiés',
                        '0' => 'Non publiés',
                    ])
                    ->label('Statut'),

                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
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
            // Le gestionnaire de relation sera automatiquement détecté
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCommuniques::route('/'),
            'create' => Pages\CreateCommunique::route('/create'),
            'view' => Pages\ViewCommunique::route('/{record}'),
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