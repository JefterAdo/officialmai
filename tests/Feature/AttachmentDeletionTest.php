<?php

namespace Tests\Feature;

use App\Models\Communique;
use App\Models\CommuniqueAttachment;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\Feature\Helpers\TestHelper;
use Tests\TestCase;

class AttachmentDeletionTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        
        // Désactiver le middleware qui pourrait interférer avec les tests
        $this->withoutMiddleware([
            \App\Http\Middleware\VerifyCsrfToken::class,
            \App\Http\Middleware\ViewCache::class,
        ]);
        
        // Désactiver le cache de vue pour les tests
        config(['view.cache' => false]);
        
        // Désactiver le cache de configuration
        config(['app.debug' => true]);
    }
    
    /** @test */
    public function it_deletes_an_attachment()
    {
        // Créer un utilisateur admin
        $admin = TestHelper::createAdminUser();
        
        // Créer un communiqué
        $communique = Communique::factory()->create([
            'has_attachments' => true,
        ]);
        
        // Créer une pièce jointe
        $file = UploadedFile::fake()->create('document.pdf', 100);
        $filePath = 'communiques/documents/test_' . time() . '.pdf';
        
        $attachment = CommuniqueAttachment::create([
            'communique_id' => $communique->id,
            'file_path' => $filePath,
            'file_type' => 'pdf',
            'original_name' => 'document.pdf',
            'size' => 100,
            'mime_type' => 'application/pdf',
            'download_count' => 0,
        ]);
        
        // Simuler le fichier dans le stockage
        Storage::fake('public');
        Storage::disk('public')->put($filePath, $file->getContent());
        
        // Vérifier que le fichier existe avant la suppression
        Storage::disk('public')->assertExists($filePath);
        
        // Appeler directement la méthode du contrôleur
        $controller = new \App\Http\Controllers\CommuniqueController();
        $response = $controller->deleteAttachment($communique, $attachment->id);
        
        // Vérifier la réponse
        $this->assertEquals(200, $response->getStatusCode());
        $responseData = json_decode($response->getContent(), true);
        $this->assertTrue($responseData['success']);
        
        // Vérifier que la pièce jointe a été supprimée de la base de données
        $this->assertDatabaseMissing('communique_attachments', [
            'id' => $attachment->id,
        ]);
        
        // Vérifier que le fichier a été supprimé du stockage
        Storage::disk('public')->assertMissing($filePath);
        
        // Vérifier que le statut du communiqué a été mis à jour
        $this->assertFalse($communique->fresh()->has_attachments);
    }
}
