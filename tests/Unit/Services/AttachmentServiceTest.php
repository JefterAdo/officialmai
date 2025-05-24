<?php

namespace Tests\Unit\Services;

use App\Models\Communique;
use App\Models\CommuniqueAttachment;
use App\Services\AttachmentService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class AttachmentServiceTest extends TestCase
{
    use RefreshDatabase;

    protected $service;
    protected $communique;
    protected $attachment;
    protected $filePath = 'communiques/documents/test.pdf';

    protected function setUp(): void
    {
        parent::setUp();
        
        // Créer un communiqué
        $this->communique = Communique::factory()->create([
            'has_attachments' => true,
        ]);
        
        // Créer une pièce jointe
        $this->attachment = CommuniqueAttachment::create([
            'id' => 1,
            'communique_id' => $this->communique->id,
            'file_path' => $this->filePath,
            'file_type' => 'pdf',
            'original_name' => 'document.pdf',
            'size' => 100,
            'mime_type' => 'application/pdf',
            'download_count' => 0,
        ]);
        
        // Simuler le stockage
        Storage::fake('public');
        Storage::disk('public')->put($this->filePath, 'test content');
        
        // Initialiser le service
        $this->service = new AttachmentService();
    }
    
    /** @test */
    public function it_deletes_an_attachment()
    {
        // Vérifier que le fichier existe avant la suppression
        Storage::disk('public')->assertExists($this->filePath);
        
        // Appeler la méthode du service
        $result = $this->service->deleteAttachment($this->attachment);
        
        // Vérifier le résultat
        $this->assertTrue($result);
        
        // Vérifier que le fichier a été supprimé du stockage
        Storage::disk('public')->assertMissing($this->filePath);
        
        // Vérifier que la pièce jointe a été supprimée de la base de données
        $this->assertDatabaseMissing('communique_attachments', [
            'id' => $this->attachment->id,
        ]);
    }
    
    /** @test */
    public function it_handles_nonexistent_file()
    {
        // Supprimer le fichier du stockage
        Storage::disk('public')->delete($this->filePath);
        
        // Appeler la méthode du service
        $result = $this->service->deleteAttachment($this->attachment);
        
        // Vérifier que la méthode retourne true même si le fichier n'existe pas
        $this->assertTrue($result);
        
        // Vérifier que la pièce jointe a été supprimée de la base de données
        $this->assertDatabaseMissing('communique_attachments', [
            'id' => $this->attachment->id,
        ]);
    }
}
