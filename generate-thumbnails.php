<?php
// Script pour générer des miniatures pour l'interface d'administration
require __DIR__ . '/vendor/autoload.php';
$app = require __DIR__ . '/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use App\Models\Slide;
use Intervention\Image\Facades\Image;

echo "=== GÉNÉRATION DE MINIATURES POUR L'ADMIN ===\n\n";

// Créer le dossier des miniatures s'il n'existe pas
$thumbnailsDir = storage_path('app/public/thumbnails');
if (!is_dir($thumbnailsDir)) {
    mkdir($thumbnailsDir, 0777, true);
    echo "Dossier de miniatures créé: {$thumbnailsDir}\n";
}

// Créer le dossier public des miniatures s'il n'existe pas
$publicThumbnailsDir = public_path('storage/thumbnails');
if (!is_dir($publicThumbnailsDir)) {
    mkdir($publicThumbnailsDir, 0777, true);
    echo "Dossier public de miniatures créé: {$publicThumbnailsDir}\n";
}

// Récupérer tous les slides
$slides = Slide::all();
echo "Nombre de slides trouvés: " . $slides->count() . "\n\n";

// Générer des miniatures pour chaque slide
foreach ($slides as $slide) {
    $imagePath = $slide->image_path;
    $fullPath = storage_path('app/public/' . $imagePath);
    
    echo "Traitement de l'image: {$imagePath}\n";
    
    // Vérifier si l'image existe
    if (!file_exists($fullPath)) {
        echo "  ❌ Image source introuvable: {$fullPath}\n";
        continue;
    }
    
    // Générer un nom de fichier pour la miniature
    $filename = pathinfo($imagePath, PATHINFO_FILENAME);
    $extension = pathinfo($imagePath, PATHINFO_EXTENSION);
    $thumbnailName = $filename . '_thumb.' . $extension;
    $thumbnailPath = 'thumbnails/' . $thumbnailName;
    $thumbnailFullPath = storage_path('app/public/' . $thumbnailPath);
    $thumbnailPublicPath = public_path('storage/' . $thumbnailPath);
    
    try {
        // Créer la miniature
        $img = Image::make($fullPath);
        $img->resize(300, 200, function ($constraint) {
            $constraint->aspectRatio();
            $constraint->upsize();
        });
        $img->save($thumbnailFullPath);
        
        // Copier la miniature dans le dossier public
        copy($thumbnailFullPath, $thumbnailPublicPath);
        
        // Mettre à jour le slide avec le chemin de la miniature
        $slide->thumbnail_path = $thumbnailPath;
        $slide->save();
        
        echo "  ✅ Miniature créée: {$thumbnailPath}\n";
    } catch (Exception $e) {
        echo "  ❌ Erreur lors de la création de la miniature: " . $e->getMessage() . "\n";
    }
}

// Mettre à jour la table slides pour ajouter une colonne thumbnail_path si elle n'existe pas
try {
    if (!Schema::hasColumn('slides', 'thumbnail_path')) {
        Schema::table('slides', function ($table) {
            $table->string('thumbnail_path')->nullable()->after('image_path');
        });
        echo "\n✅ Colonne thumbnail_path ajoutée à la table slides\n";
    } else {
        echo "\n✅ Colonne thumbnail_path existe déjà dans la table slides\n";
    }
} catch (Exception $e) {
    echo "\n❌ Erreur lors de la modification de la table slides: " . $e->getMessage() . "\n";
}

// Mettre à jour le fichier SlideResource.php pour utiliser les miniatures
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
                Tables\Columns\ImageColumn::make('thumbnail_path')
                    ->disk('public')
                    ->label('Image')
                    ->defaultImageUrl(function (Slide $record): ?string {
                        return $record->image_path ? asset('storage/' . $record->image_path) : null;
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
echo "\n✅ Fichier SlideResource.php mis à jour pour utiliser les miniatures\n";

// Créer un fichier URL.php personnalisé pour gérer les URLs des images
$urlServicePath = app_path('Services/UrlService.php');
$urlServiceDir = dirname($urlServicePath);
if (!is_dir($urlServiceDir)) {
    mkdir($urlServiceDir, 0777, true);
}

$urlServiceContent = <<<'PHP'
<?php

namespace App\Services;

use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;

class UrlService
{
    /**
     * Génère une URL pour un fichier stocké
     *
     * @param string|null $path
     * @return string|null
     */
    public static function storage(?string $path): ?string
    {
        if (empty($path)) {
            return null;
        }
        
        // Utiliser une URL directe pour contourner les problèmes de liens symboliques
        return '/storage/' . $path;
    }
    
    /**
     * Génère une URL pour une miniature
     *
     * @param string|null $path
     * @return string|null
     */
    public static function thumbnail(?string $path): ?string
    {
        if (empty($path)) {
            return null;
        }
        
        $filename = pathinfo($path, PATHINFO_FILENAME);
        $extension = pathinfo($path, PATHINFO_EXTENSION);
        $dir = dirname($path);
        $dir = $dir === '.' ? 'thumbnails' : $dir;
        
        return '/storage/thumbnails/' . $filename . '_thumb.' . $extension;
    }
}
PHP;

file_put_contents($urlServicePath, $urlServiceContent);
echo "✅ Fichier UrlService.php créé pour gérer les URLs des images\n";

// Mettre à jour le provider AppServiceProvider.php pour enregistrer le service URL
$appServiceProviderPath = app_path('Providers/AppServiceProvider.php');
$appServiceProviderContent = file_get_contents($appServiceProviderPath);

// Vérifier si le service est déjà enregistré
if (strpos($appServiceProviderContent, 'UrlService') === false) {
    // Ajouter l'import
    $appServiceProviderContent = str_replace(
        'namespace App\\Providers;',
        "namespace App\\Providers;\n\nuse App\\Services\\UrlService;",
        $appServiceProviderContent
    );
    
    // Enregistrer le service
    $appServiceProviderContent = str_replace(
        'public function boot(): void',
        "public function boot(): void\n    {\n        // Enregistrer le service URL\n        \$this->app->singleton(UrlService::class);\n",
        $appServiceProviderContent
    );
    
    file_put_contents($appServiceProviderPath, $appServiceProviderContent);
    echo "✅ AppServiceProvider.php mis à jour pour enregistrer le service URL\n";
} else {
    echo "✅ Le service URL est déjà enregistré dans AppServiceProvider.php\n";
}

echo "\n=== RÉSUMÉ ===\n";
echo "✅ Miniatures générées pour les slides\n";
echo "✅ Configuration Filament mise à jour pour utiliser les miniatures\n";
echo "✅ Service URL créé pour gérer les URLs des images\n";
echo "\nVeuillez vider le cache et rafraîchir l'interface d'administration.\n";
