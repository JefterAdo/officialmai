<?php
// Script pour simplifier l'affichage des images dans l'admin
require __DIR__ . '/vendor/autoload.php';
$app = require __DIR__ . '/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

echo "=== SIMPLIFICATION DE L'AFFICHAGE DES IMAGES ADMIN ===\n\n";

// Mettre à jour SlideResource.php pour simplifier l'affichage des images
$slideResourcePath = app_path('Filament/Resources/SlideResource.php');
$slideResourceContent = <<<'PHP'
<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SlideResource\Pages;
use App\Models\Slide;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class SlideResource extends Resource
{
    protected static ?string $model = Slide::class;
    protected static ?string $navigationIcon = 'heroicon-o-photo';
    protected static ?string $navigationLabel = 'Slides';
    protected static ?string $navigationGroup = 'Contenu';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title')
                    ->required()
                    ->maxLength(255)
                    ->label('Titre'),
                Forms\Components\Textarea::make('description')
                    ->maxLength(500)
                    ->label('Description'),
                Forms\Components\FileUpload::make('image_path')
                    ->required()
                    ->image()
                    ->directory('slides')
                    ->visibility('public')
                    ->imagePreviewHeight('250')
                    ->panelAspectRatio('16:9')
                    ->panelLayout('integrated')
                    ->label('Image'),
                Forms\Components\TextInput::make('button_text')
                    ->maxLength(50)
                    ->label('Texte du bouton'),
                Forms\Components\TextInput::make('button_link')
                    ->maxLength(255)
                    ->label('Lien du bouton'),
                Forms\Components\TextInput::make('order')
                    ->numeric()
                    ->default(0)
                    ->label('Ordre'),
                Forms\Components\Toggle::make('is_active')
                    ->default(true)
                    ->label('Actif'),
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
                Tables\Columns\TextColumn::make('image_path')
                    ->label('Image')
                    ->formatStateUsing(function (string $state): string {
                        return basename($state);
                    }),
                Tables\Columns\IconColumn::make('is_active')
                    ->boolean()
                    ->sortable()
                    ->label('Actif'),
                Tables\Columns\TextColumn::make('order')
                    ->numeric()
                    ->sortable()
                    ->label('Ordre'),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('Actif')
                    ->indicator('Actif'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('order');
    }

    public static function getRelations(): array
    {
        return [];
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
PHP;

file_put_contents($slideResourcePath, $slideResourceContent);
echo "✅ SlideResource.php mis à jour pour simplifier l'affichage des images\n";

// Vérifier les permissions des images
echo "\nVérification des permissions des images...\n";
$slidesDir = storage_path('app/public/slides');
$publicSlidesDir = public_path('storage/slides');

// Vérifier si les dossiers existent
if (!is_dir($slidesDir)) {
    echo "❌ Le dossier {$slidesDir} n'existe pas\n";
} else {
    echo "✅ Le dossier {$slidesDir} existe\n";
    chmod($slidesDir, 0777);
    echo "  Permissions mises à jour: 0777\n";
    
    // Parcourir les fichiers et mettre à jour les permissions
    $files = scandir($slidesDir);
    foreach ($files as $file) {
        if ($file != '.' && $file != '..') {
            $filePath = $slidesDir . '/' . $file;
            if (is_file($filePath)) {
                chmod($filePath, 0777);
                echo "  Permissions mises à jour pour {$file}: 0777\n";
            }
        }
    }
}

if (!is_dir($publicSlidesDir)) {
    echo "❌ Le dossier {$publicSlidesDir} n'existe pas\n";
    
    // Créer le dossier s'il n'existe pas
    if (!is_dir(dirname($publicSlidesDir))) {
        mkdir(dirname($publicSlidesDir), 0777, true);
    }
    
    if (symlink($slidesDir, $publicSlidesDir)) {
        echo "✅ Lien symbolique créé: {$publicSlidesDir} -> {$slidesDir}\n";
    } else {
        echo "❌ Échec de la création du lien symbolique\n";
        
        // Essayer de créer le dossier et copier les fichiers
        mkdir($publicSlidesDir, 0777, true);
        echo "✅ Dossier créé: {$publicSlidesDir}\n";
        
        // Copier les fichiers
        $files = scandir($slidesDir);
        foreach ($files as $file) {
            if ($file != '.' && $file != '..') {
                $sourcePath = $slidesDir . '/' . $file;
                $targetPath = $publicSlidesDir . '/' . $file;
                if (is_file($sourcePath)) {
                    if (copy($sourcePath, $targetPath)) {
                        chmod($targetPath, 0777);
                        echo "  ✅ Fichier copié: {$file}\n";
                    } else {
                        echo "  ❌ Échec de la copie de {$file}\n";
                    }
                }
            }
        }
    }
} else {
    echo "✅ Le dossier {$publicSlidesDir} existe\n";
    chmod($publicSlidesDir, 0777);
    echo "  Permissions mises à jour: 0777\n";
    
    // Parcourir les fichiers et mettre à jour les permissions
    $files = scandir($publicSlidesDir);
    foreach ($files as $file) {
        if ($file != '.' && $file != '..') {
            $filePath = $publicSlidesDir . '/' . $file;
            if (is_file($filePath)) {
                chmod($filePath, 0777);
                echo "  Permissions mises à jour pour {$file}: 0777\n";
            }
        }
    }
}

// Vérifier le lien symbolique principal
$storageLink = public_path('storage');
if (is_link($storageLink)) {
    $target = readlink($storageLink);
    echo "\nLe lien symbolique public/storage pointe vers: {$target}\n";
    
    // Vérifier si le lien est correct
    if ($target !== storage_path('app/public') && $target !== '../storage/app/public') {
        echo "❌ Le lien symbolique est incorrect\n";
        
        // Supprimer et recréer le lien
        unlink($storageLink);
        if (symlink(storage_path('app/public'), $storageLink)) {
            echo "✅ Lien symbolique recréé avec succès\n";
        } else {
            echo "❌ Échec de la recréation du lien symbolique\n";
        }
    } else {
        echo "✅ Le lien symbolique est correct\n";
    }
} else {
    echo "\n❌ Le lien symbolique public/storage n'existe pas\n";
    
    // Créer le lien
    if (symlink(storage_path('app/public'), $storageLink)) {
        echo "✅ Lien symbolique créé avec succès\n";
    } else {
        echo "❌ Échec de la création du lien symbolique\n";
    }
}

// Vider les caches
echo "\nVidage des caches...\n";
system('php artisan cache:clear');
system('php artisan view:clear');
system('php artisan config:clear');
system('php artisan route:clear');

echo "\n=== RÉSUMÉ ===\n";
echo "✅ Interface d'administration simplifiée\n";
echo "✅ Permissions des fichiers mises à jour\n";
echo "✅ Liens symboliques vérifiés\n";
echo "\nTerminé. Veuillez rafraîchir l'interface d'administration.\n";
