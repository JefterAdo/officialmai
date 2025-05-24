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

class CommuniqueAttachmentApiTest extends TestCase
{
    use RefreshDatabase;

    protected $admin;
    protected $communique;
    protected $attachment;
    protected $filePath;

    protected function setUp(): void
    {
        parent::setUp();
        
        // Créer un utilisateur admin pour les tests
        $this->admin = TestHelper::createAdminUser();
        
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
    }
    
    /** @test */
    public function admin_can_delete_an_attachment()
    {
        // Vérifier que le fichier existe avant la suppression
        Storage::disk('public')->assertExists($this->filePath);
        
        // Tenter de supprimer la pièce jointe via l'API
        $response = $this->actingAs($this->admin)
            ->withHeaders([
                'Accept' => 'application/json',
                'X-Requested-With' => 'XMLHttpRequest'
            ])
            ->delete(route('communiques.attachments.destroy', [
                'communique' => $this->communique->id,
                'attachment' => $this->attachment->id
            ]));
            
        // Vérifier la réponse
        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'message' => 'La pièce jointe a été supprimée avec succès.'
            ]);
            
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
    public function non_admin_cannot_delete_an_attachment()
    {
        // Créer un utilisateur non admin
        $user = User::factory()->create();
        
        // Tenter de supprimer la pièce jointe en tant qu'utilisateur non admin
        $response = $this->actingAs($user)
            ->withHeaders([
                'Accept' => 'application/json',
                'X-Requested-With' => 'XMLHttpRequest'
            ])
            ->delete(route('communiques.attachments.destroy', [
                'communique' => $this->communique->id,
                'attachment' => $this->attachment->id
            ]));
            
        // Vérifier que l'accès est refusé
        $response->assertStatus(403);
        
        // Vérifier que la pièce jointe n'a pas été supprimée
        $this->assertDatabaseHas('communique_attachments', [
            'id' => $this->attachment->id,
        ]);
    }
}
