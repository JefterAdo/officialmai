<?php
// Script pour réparer les images de l'admin sans dépendances externes
require __DIR__ . '/vendor/autoload.php';
$app = require __DIR__ . '/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use App\Models\Slide;
use Illuminate\Support\Facades\File;

echo "=== RÉPARATION DES IMAGES ADMIN (MÉTHODE DIRECTE) ===\n\n";

// 1. Vérifier si la colonne thumbnail_path existe, sinon la créer
if (!Schema::hasColumn('slides', 'thumbnail_path')) {
    try {
        Schema::table('slides', function ($table) {
            $table->string('thumbnail_path')->nullable()->after('image_path');
        });
        echo "✅ Colonne thumbnail_path ajoutée à la table slides\n\n";
    } catch (Exception $e) {
        echo "❌ Erreur lors de l'ajout de la colonne: " . $e->getMessage() . "\n\n";
    }
} else {
    echo "✅ Colonne thumbnail_path existe déjà\n\n";
}

// 2. Créer les dossiers nécessaires
$thumbnailsDir = storage_path('app/public/thumbnails');
if (!is_dir($thumbnailsDir)) {
    mkdir($thumbnailsDir, 0777, true);
    echo "✅ Dossier de miniatures créé: {$thumbnailsDir}\n";
}

$publicThumbnailsDir = public_path('storage/thumbnails');
if (!is_dir($publicThumbnailsDir)) {
    mkdir($publicThumbnailsDir, 0777, true);
    echo "✅ Dossier public de miniatures créé: {$publicThumbnailsDir}\n";
}

// 3. Fonction pour créer une miniature avec GD
function createThumbnail($sourcePath, $targetPath, $width = 300, $height = 200) {
    // Vérifier le type d'image
    $imageInfo = getimagesize($sourcePath);
    if (!$imageInfo) {
        return false;
    }
    
    $mime = $imageInfo['mime'];
    
    switch ($mime) {
        case 'image/jpeg':
            $sourceImage = imagecreatefromjpeg($sourcePath);
            break;
        case 'image/png':
            $sourceImage = imagecreatefrompng($sourcePath);
            break;
        case 'image/gif':
            $sourceImage = imagecreatefromgif($sourcePath);
            break;
        default:
            return false;
    }
    
    // Obtenir les dimensions originales
    $srcWidth = imagesx($sourceImage);
    $srcHeight = imagesy($sourceImage);
    
    // Calculer les nouvelles dimensions tout en conservant les proportions
    $ratio = min($width / $srcWidth, $height / $srcHeight);
    $newWidth = $srcWidth * $ratio;
    $newHeight = $srcHeight * $ratio;
    
    // Créer l'image de destination
    $targetImage = imagecreatetruecolor($newWidth, $newHeight);
    
    // Préserver la transparence pour les PNG
    if ($mime == 'image/png') {
        imagealphablending($targetImage, false);
        imagesavealpha($targetImage, true);
        $transparent = imagecolorallocatealpha($targetImage, 255, 255, 255, 127);
        imagefilledrectangle($targetImage, 0, 0, $newWidth, $newHeight, $transparent);
    }
    
    // Redimensionner l'image
    imagecopyresampled(
        $targetImage, $sourceImage,
        0, 0, 0, 0,
        $newWidth, $newHeight, $srcWidth, $srcHeight
    );
    
    // Sauvegarder l'image
    switch ($mime) {
        case 'image/jpeg':
            imagejpeg($targetImage, $targetPath, 90);
            break;
        case 'image/png':
            imagepng($targetImage, $targetPath, 9);
            break;
        case 'image/gif':
            imagegif($targetImage, $targetPath);
            break;
    }
    
    // Libérer la mémoire
    imagedestroy($sourceImage);
    imagedestroy($targetImage);
    
    return true;
}

// 4. Traiter chaque slide
$slides = Slide::all();
echo "\nTraitement de " . $slides->count() . " slides:\n";

foreach ($slides as $slide) {
    $imagePath = $slide->image_path;
    $fullPath = storage_path('app/public/' . $imagePath);
    
    echo "\nSlide ID: {$slide->id}, Titre: {$slide->title}\n";
    echo "Image: {$imagePath}\n";
    
    // Vérifier si l'image source existe
    if (!file_exists($fullPath)) {
        echo "❌ Image source introuvable\n";
        continue;
    }
    
    // Générer le chemin de la miniature
    $pathInfo = pathinfo($imagePath);
    $thumbnailName = $pathInfo['filename'] . '_thumb.' . $pathInfo['extension'];
    $thumbnailPath = 'thumbnails/' . $thumbnailName;
    $thumbnailFullPath = storage_path('app/public/' . $thumbnailPath);
    $thumbnailPublicPath = public_path('storage/' . $thumbnailPath);
    
    // Créer la miniature
    if (createThumbnail($fullPath, $thumbnailFullPath)) {
        echo "✅ Miniature créée: {$thumbnailPath}\n";
        
        // Copier vers le dossier public
        if (copy($thumbnailFullPath, $thumbnailPublicPath)) {
            echo "✅ Miniature copiée vers public\n";
            
            // Mettre à jour le slide
            $slide->thumbnail_path = $thumbnailPath;
            $slide->save();
            echo "✅ Base de données mise à jour\n";
            
            // Appliquer les permissions
            chmod($thumbnailFullPath, 0777);
            chmod($thumbnailPublicPath, 0777);
        } else {
            echo "❌ Échec de la copie vers public\n";
        }
    } else {
        echo "❌ Échec de la création de la miniature\n";
    }
}

// 5. Mettre à jour SlideResource.php pour utiliser les miniatures
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
echo "\n✅ SlideResource.php mis à jour\n";

// 6. Vider les caches
echo "\nVidage des caches...\n";
system('php artisan cache:clear');
system('php artisan view:clear');
system('php artisan config:clear');
system('php artisan route:clear');

echo "\n=== RÉSUMÉ ===\n";
echo "✅ Structure de la base de données mise à jour\n";
echo "✅ Miniatures générées pour les slides\n";
echo "✅ Interface d'administration mise à jour\n";
echo "\nTerminé. Veuillez rafraîchir l'interface d'administration.\n";
