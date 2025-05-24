<?php

namespace Tests\Unit;

use App\Http\Controllers\CommuniqueController;
use App\Models\Communique;
use App\Models\CommuniqueAttachment;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class CommuniqueControllerTest extends TestCase
{
    use RefreshDatabase;

    protected $controller;
    protected $user;
    protected $communique;
    protected $attachment;

    protected function setUp(): void
    {
        parent::setUp();
        
        // Créer un utilisateur admin
        $this->user = User::factory()->create();
        $this->user->assignRole('admin');
        
        // Créer un communiqué avec une pièce jointe
        $this->communique = Communique::factory()->create([
            'has_attachments' => true,
        ]);
        
        $file = UploadedFile::fake()->create('document.pdf', 100);
        $this->filePath = 'communiques/documents/test_' . time() . '.pdf';
        
        $this->attachment = CommuniqueAttachment::create([
            'communique_id' => $this->communique->id,
            'file_path' => $this->filePath,
            'file_type' => 'pdf',
            'original_name' => 'document.pdf',
            'size' => 100,
            'mime_type' => 'application/pdf',
            'download_count' => 0,
        ]);
        
        // Simuler le fichier dans le stockage
        Storage::fake('public');
        Storage::disk('public')->put($this->filePath, $file->getContent());
        
        // Initialiser le contrôleur
        $this->controller = new CommuniqueController();
        
        // Simuler l'authentification
        $this->actingAs($this->user);
    }
    
    /** @test */
    public function it_deletes_an_attachment()
    {
        // Vérifier que le fichier existe avant la suppression
        Storage::disk('public')->assertExists($this->filePath);
        
        // Appeler la méthode du contrôleur
        $response = $this->controller->deleteAttachment($this->communique, $this->attachment->id);
        
        // Vérifier la réponse
        $this->assertEquals(200, $response->getStatusCode());
        $responseData = json_decode($response->getContent(), true);
        $this->assertTrue($responseData['success']);
        $this->assertEquals('La pièce jointe a été supprimée avec succès.', $responseData['message']);
        
        // Vérifier que la pièce jointe a été supprimée de la base de données
        $this->assertDatabaseMissing('communique_attachments', [
            'id' => $this->attachment->id,
        ]);
        
        // Vérifier que le fichier a été supprimé du stockage
        Storage::disk('public')->assertMissing($this->filePath);
        
        // Vérifier que le statut du communiqué a été mis à jour
        $this->assertFalse($this->communique->fresh()->has_attachments);
    }
    
    /** @test */
    public function it_handles_nonexistent_attachment()
    {
        // Appeler la méthode avec un ID de pièce jointe inexistant
        $response = $this->controller->deleteAttachment($this->communique, 9999);
        
        // Vérifier la réponse d'erreur
        $this->assertEquals(500, $response->getStatusCode());
        $responseData = json_decode($response->getContent(), true);
        $this->assertFalse($responseData['success']);
        $this->assertStringContainsString('No query results for model', $responseData['message']);
    }
}
