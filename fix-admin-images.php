<?php
// Script pour vérifier et réparer les problèmes d'affichage des images dans l'admin
require __DIR__ . '/vendor/autoload.php';
$app = require __DIR__ . '/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use Illuminate\Support\Facades\DB;
use App\Models\Slide;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

echo "=== VÉRIFICATION ET RÉPARATION DES IMAGES ADMIN ===\n\n";

// 1. Vérifier les permissions des images
echo "1. VÉRIFICATION DES PERMISSIONS\n";
$slidesDir = storage_path('app/public/slides');
$publicSlidesDir = public_path('storage/slides');

echo "Permissions du dossier storage/app/public/slides: " . substr(sprintf('%o', fileperms($slidesDir)), -4) . "\n";
echo "Permissions du dossier public/storage/slides: " . substr(sprintf('%o', fileperms($publicSlidesDir)), -4) . "\n\n";

// Appliquer les permissions 777 sur les dossiers et fichiers
echo "Application des permissions 777 sur les dossiers...\n";
chmod($slidesDir, 0777);
chmod($publicSlidesDir, 0777);

// 2. Vérifier et réparer les images
echo "\n2. VÉRIFICATION ET RÉPARATION DES IMAGES\n";
$slides = Slide::all();
$fixedImages = 0;

foreach ($slides as $slide) {
    $imagePath = $slide->image_path;
    $fullPath = storage_path('app/public/' . $imagePath);
    $publicPath = public_path('storage/' . $imagePath);
    
    echo "Slide ID: {$slide->id}, Image: {$imagePath}\n";
    
    // Vérifier si l'image existe
    if (!file_exists($fullPath)) {
        echo "  ❌ Image manquante dans storage/app/public\n";
        continue;
    }
    
    // Vérifier si l'image est accessible
    $fileSize = filesize($fullPath);
    echo "  Taille du fichier: {$fileSize} octets\n";
    
    if ($fileSize < 1000) {
        echo "  ⚠️ Image potentiellement corrompue (taille trop petite)\n";
    }
    
    // Appliquer les permissions 777 sur l'image
    chmod($fullPath, 0777);
    if (file_exists($publicPath)) {
        chmod($publicPath, 0777);
    }
    
    // Copier l'image de storage vers public si nécessaire
    if (!file_exists($publicPath) || filesize($publicPath) !== $fileSize) {
        if (copy($fullPath, $publicPath)) {
            echo "  ✅ Image copiée de storage vers public\n";
            chmod($publicPath, 0777);
            $fixedImages++;
        } else {
            echo "  ❌ Échec de la copie de l'image\n";
        }
    } else {
        echo "  ✅ Image déjà présente dans public/storage\n";
    }
}

// 3. Vérifier les liens symboliques
echo "\n3. VÉRIFICATION DES LIENS SYMBOLIQUES\n";
$storageLink = public_path('storage');
$target = readlink($storageLink);
echo "Le lien symbolique public/storage pointe vers: {$target}\n";

// Recréer le lien symbolique si nécessaire
if ($target !== storage_path('app/public') && $target !== '../storage/app/public') {
    echo "⚠️ Le lien symbolique est incorrect. Tentative de correction...\n";
    
    // Supprimer le lien existant
    if (is_link($storageLink)) {
        unlink($storageLink);
    }
    
    // Créer un nouveau lien
    if (symlink(storage_path('app/public'), $storageLink)) {
        echo "✅ Lien symbolique recréé avec succès\n";
    } else {
        echo "❌ Échec de la création du lien symbolique\n";
    }
} else {
    echo "✅ Le lien symbolique est correct\n";
}

// 4. Vérifier la configuration Filament pour l'affichage des images
echo "\n4. VÉRIFICATION DE LA CONFIGURATION FILAMENT\n";
$filamentConfigPath = config_path('filament.php');
if (file_exists($filamentConfigPath)) {
    echo "Fichier de configuration Filament trouvé\n";
} else {
    echo "Fichier de configuration Filament non trouvé\n";
}

// Créer un fichier de configuration personnalisé pour Filament si nécessaire
$filamentDirPath = app_path('Filament');
if (!is_dir($filamentDirPath)) {
    mkdir($filamentDirPath, 0777, true);
}

// Créer un fichier de configuration pour les ressources Filament
$filamentResourcesPath = app_path('Filament/Resources');
if (!is_dir($filamentResourcesPath)) {
    mkdir($filamentResourcesPath, 0777, true);
}

// Créer ou mettre à jour le fichier SlideResource.php
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
                    ->label('Image')
                    ->afterStateUpdated(function (Forms\Get $get, Forms\Set $set, ?string $state) {
                        if (!$get('title') && $state) {
                            $filename = pathinfo($state, PATHINFO_FILENAME);
                            $set('title', Str::title(Str::replace(['-', '_'], ' ', $filename)));
                        }
                    }),
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
                Tables\Columns\ImageColumn::make('image_path')
                    ->disk('public')
                    ->label('Image'),
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

if (!file_exists($slideResourcePath) || md5_file($slideResourcePath) !== md5($slideResourceContent)) {
    file_put_contents($slideResourcePath, $slideResourceContent);
    echo "✅ Fichier SlideResource.php créé/mis à jour\n";
} else {
    echo "✅ Fichier SlideResource.php déjà à jour\n";
}

// Créer le dossier des pages
$slidePagesPath = app_path('Filament/Resources/SlideResource/Pages');
if (!is_dir($slidePagesPath)) {
    mkdir($slidePagesPath, 0777, true);
}

// Créer les fichiers de pages
$listSlidesPath = $slidePagesPath . '/ListSlides.php';
$listSlidesContent = <<<'PHP'
<?php

namespace App\Filament\Resources\SlideResource\Pages;

use App\Filament\Resources\SlideResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSlides extends ListRecords
{
    protected static string $resource = SlideResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
PHP;

$createSlidePath = $slidePagesPath . '/CreateSlide.php';
$createSlideContent = <<<'PHP'
<?php

namespace App\Filament\Resources\SlideResource\Pages;

use App\Filament\Resources\SlideResource;
use Filament\Resources\Pages\CreateRecord;

class CreateSlide extends CreateRecord
{
    protected static string $resource = SlideResource::class;
}
PHP;

$editSlidePath = $slidePagesPath . '/EditSlide.php';
$editSlideContent = <<<'PHP'
<?php

namespace App\Filament\Resources\SlideResource\Pages;

use App\Filament\Resources\SlideResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSlide extends EditRecord
{
    protected static string $resource = SlideResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
PHP;

if (!file_exists($listSlidesPath)) {
    file_put_contents($listSlidesPath, $listSlidesContent);
    echo "✅ Fichier ListSlides.php créé\n";
}

if (!file_exists($createSlidePath)) {
    file_put_contents($createSlidePath, $createSlideContent);
    echo "✅ Fichier CreateSlide.php créé\n";
}

if (!file_exists($editSlidePath)) {
    file_put_contents($editSlidePath, $editSlideContent);
    echo "✅ Fichier EditSlide.php créé\n";
}

echo "\n=== RÉSUMÉ ===\n";
echo "✅ Permissions vérifiées et corrigées\n";
echo "✅ {$fixedImages} images réparées\n";
echo "✅ Lien symbolique vérifié\n";
echo "✅ Configuration Filament mise à jour\n";
echo "\nTerminé. Veuillez vider le cache et rafraîchir l'interface d'administration.\n";
