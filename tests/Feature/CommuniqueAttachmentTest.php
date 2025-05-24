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
use App\Http\Controllers\CommuniqueController;

class CommuniqueAttachmentTest extends TestCase
{
    use RefreshDatabase;

    protected $admin;
    protected $controller;

    protected function setUp(): void
    {
        parent::setUp();
        
        // Créer un utilisateur admin pour les tests
        $this->admin = TestHelper::createAdminUser();
        
        // Initialiser le contrôleur
        $this->controller = new CommuniqueController();
        
        // Simuler le stockage
        Storage::fake('public');
    }
    
    /** @test */
    public function admin_can_delete_an_attachment()
    {
        // Créer un communiqué avec une pièce jointe
        $communique = Communique::factory()->create([
            'has_attachments' => true,
        ]);
        
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
        Storage::disk('public')->put($filePath, $file->getContent());
        
        // Vérifier que le fichier existe dans le stockage
        Storage::disk('public')->assertExists($filePath);
        
        // Appeler directement la méthode du contrôleur
        $response = $this->actingAs($this->admin);
        $result = $this->controller->deleteAttachment($communique, $attachment->id);
        
        // Vérifier la réponse
        $this->assertEquals(200, $result->getStatusCode());
        $responseData = json_decode($result->getContent(), true);
        $this->assertTrue($responseData['success']);
        $this->assertEquals('La pièce jointe a été supprimée avec succès.', $responseData['message']);
        
        // Vérifier que la pièce jointe a été supprimée de la base de données
        $this->assertDatabaseMissing('communique_attachments', [
            'id' => $attachment->id,
        ]);
        
        // Vérifier que le fichier a été supprimé du stockage
        Storage::disk('public')->assertMissing($filePath);
        
        // Vérifier que le statut du communiqué a été mis à jour
        $this->assertFalse($communique->fresh()->has_attachments);
    }
    
    /** @test */
    public function non_admin_cannot_delete_an_attachment()
    {
        // Créer un utilisateur non admin
        $user = User::factory()->create();
        
        // Créer un communiqué avec une pièce jointe
        $communique = Communique::factory()->create([
            'has_attachments' => true,
        ]);
        
        $file = UploadedFile::fake()->create('document.pdf', 100);
        
        $attachment = CommuniqueAttachment::create([
            'communique_id' => $communique->id,
            'file_path' => $file->store('communiques/documents', 'public'),
            'file_type' => 'pdf',
            'original_name' => 'document.pdf',
            'size' => 100,
            'mime_type' => 'application/pdf',
            'download_count' => 0,
        ]);
        
        // Tenter de supprimer la pièce jointe en tant qu'utilisateur non admin
        $response = $this->actingAs($user)
            ->deleteJson(route('communiques.attachments.destroy', [
                'communique' => $communique->id,
                'attachment' => $attachment->id
            ]));
            
        // Vérifier que l'accès est refusé
        $response->assertStatus(403);
        
        // Vérifier que la pièce jointe n'a pas été supprimée
        $this->assertDatabaseHas('communique_attachments', [
            'id' => $attachment->id,
        ]);
    }
}
