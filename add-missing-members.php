<?php

// Script pour ajouter les membres manquants à l'organisation
require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\OrganizationStructure;
use Illuminate\Support\Facades\DB;

// Commencer une transaction pour s'assurer que toutes les opérations sont effectuées ou aucune
DB::beginTransaction();

try {
    // Ajouter les membres du secrétariat exécutif
    $secretariatMembers = [
        [
            'name' => 'M. Claude SAHI',
            'title' => 'Secrétaire Exécutif Adjoint',
            'image' => 'membres/secretariat-executif/M. Claude SAHI.jpeg',
            'role' => 'secretaire_executif_adjoint',
            'group' => 'secretariat_executif',
            'order' => 1,
            'is_active' => true,
        ],
        [
            'name' => 'M. DOUMBIA Brahima',
            'title' => 'Secrétaire Exécutif Adjoint',
            'image' => 'membres/secretariat-executif/M. DOUMBIA Brahima.jpg',
            'role' => 'secretaire_executif_adjoint',
            'group' => 'secretariat_executif',
            'order' => 2,
            'is_active' => true,
        ],
        [
            'name' => 'M. Emmanuel AHOUTOU KOFFI',
            'title' => 'Secrétaire Exécutif Adjoint',
            'image' => 'membres/secretariat-executif/M. Emmanuel AHOUTOU KOFFI.jpg',
            'role' => 'secretaire_executif_adjoint',
            'group' => 'secretariat_executif',
            'order' => 3,
            'is_active' => true,
        ],
        [
            'name' => 'M. HIEN SIE Yacouba',
            'title' => 'Secrétaire Exécutif Adjoint',
            'image' => 'membres/secretariat-executif/M. HIEN SIE Yacouba.jpeg',
            'role' => 'secretaire_executif_adjoint',
            'group' => 'secretariat_executif',
            'order' => 4,
            'is_active' => true,
        ],
        [
            'name' => 'Mme Maférima DIARRASSOUBA',
            'title' => 'Secrétaire Exécutif Adjoint',
            'image' => 'membres/secretariat-executif/Mme Maférima DIARRASSOUBA.jpg',
            'role' => 'secretaire_executif_adjoint',
            'group' => 'secretariat_executif',
            'order' => 5,
            'is_active' => true,
        ],
        [
            'name' => 'Pr. Justin NGORAN KOFFI',
            'title' => 'Secrétaire Exécutif Adjoint',
            'image' => 'membres/secretariat-executif/Pr. Justin NGORAN KOFFI.jpg',
            'role' => 'secretaire_executif_adjoint',
            'group' => 'secretariat_executif',
            'order' => 6,
            'is_active' => true,
        ],
    ];

    // Ajouter les membres manquants du directoire
    $directoireMembers = [
        [
            'name' => 'M. Adama DIAWARA',
            'title' => 'Membre du Directoire',
            'image' => 'membres/directoire/M. ADAMA DIAWARA.jpg',
            'role' => 'membre_directoire',
            'group' => 'directoire',
            'order' => 10,
            'is_active' => true,
        ],
        [
            'name' => 'M. Adama KAMARA',
            'title' => 'Membre du Directoire',
            'image' => 'membres/directoire/M. ADAMA KAMARA.jpg',
            'role' => 'membre_directoire',
            'group' => 'directoire',
            'order' => 11,
            'is_active' => true,
        ],
        [
            'name' => 'M. Amadou KONE',
            'title' => 'Membre du Directoire',
            'image' => 'membres/directoire/M. AMADOU KONE.jpg',
            'role' => 'membre_directoire',
            'group' => 'directoire',
            'order' => 12,
            'is_active' => true,
        ],
        [
            'name' => 'M. Bruno NABAGNE KONE',
            'title' => 'Membre du Directoire',
            'image' => 'membres/directoire/M. BRUNO NABAGNE KONE.jpg',
            'role' => 'membre_directoire',
            'group' => 'directoire',
            'order' => 13,
            'is_active' => true,
        ],
        [
            'name' => 'M. Celestin SEREY DOH',
            'title' => 'Membre du Directoire',
            'image' => 'membres/directoire/M. CELESTIN SEREY DOH.jpeg',
            'role' => 'membre_directoire',
            'group' => 'directoire',
            'order' => 14,
            'is_active' => true,
        ],
        [
            'name' => 'M. Gaoussou TOURE',
            'title' => 'Membre du Directoire',
            'image' => 'membres/directoire/M. GAOUSSOU TOURE.jpeg',
            'role' => 'membre_directoire',
            'group' => 'directoire',
            'order' => 15,
            'is_active' => true,
        ],
        [
            'name' => 'M. Jean-Luc ASSI',
            'title' => 'Membre du Directoire',
            'image' => 'membres/directoire/M. JEAN-LUC ASSI.jpg',
            'role' => 'membre_directoire',
            'group' => 'directoire',
            'order' => 16,
            'is_active' => true,
        ],
        [
            'name' => 'M. Koffi N\'GUESSAN',
            'title' => 'Membre du Directoire',
            'image' => 'membres/directoire/M. KOFFI N\'GUESSAN.webp',
            'role' => 'membre_directoire',
            'group' => 'directoire',
            'order' => 17,
            'is_active' => true,
        ],
        [
            'name' => 'Mme Jeanne PEUHMOND',
            'title' => 'Membre du Directoire',
            'image' => 'membres/directoire/Mme JEANNE PEUHMOND.jpg',
            'role' => 'membre_directoire',
            'group' => 'directoire',
            'order' => 18,
            'is_active' => true,
        ],
        [
            'name' => 'Mme Mariatou KONE',
            'title' => 'Membre du Directoire',
            'image' => 'membres/directoire/Mme MARIATOU KONE.jpg',
            'role' => 'membre_directoire',
            'group' => 'directoire',
            'order' => 19,
            'is_active' => true,
        ],
        [
            'name' => 'Mme Raymonde GOUDOU',
            'title' => 'Membre du Directoire',
            'image' => 'membres/directoire/Mme RAYMONDE GOUDOU.jpg',
            'role' => 'membre_directoire',
            'group' => 'directoire',
            'order' => 20,
            'is_active' => true,
        ],
        [
            'name' => 'M. Moussa SANOGO',
            'title' => 'Membre du Directoire',
            'image' => 'membres/directoire/M. MOUSSA SANOGO.jpg',
            'role' => 'membre_directoire',
            'group' => 'directoire',
            'order' => 21,
            'is_active' => true,
        ],
        [
            'name' => 'M. Paulin DANHO',
            'title' => 'Membre du Directoire',
            'image' => 'membres/directoire/M. PAULIN DANHO.webp',
            'role' => 'membre_directoire',
            'group' => 'directoire',
            'order' => 22,
            'is_active' => true,
        ],
        [
            'name' => 'M. Sangafowa COULIBALY',
            'title' => 'Membre du Directoire',
            'image' => 'membres/directoire/M. SANGAFOWA COULIBALY.jpg',
            'role' => 'membre_directoire',
            'group' => 'directoire',
            'order' => 23,
            'is_active' => true,
        ],
        [
            'name' => 'M. Siandou FOFANA',
            'title' => 'Membre du Directoire',
            'image' => 'membres/directoire/M. SIANDOU FOFANA.jpg',
            'role' => 'membre_directoire',
            'group' => 'directoire',
            'order' => 24,
            'is_active' => true,
        ],
        [
            'name' => 'M. Sidi Tiemoko TOURE',
            'title' => 'Membre du Directoire',
            'image' => 'membres/directoire/M. SIDI TIEMOKO TOURE.jpg',
            'role' => 'membre_directoire',
            'group' => 'directoire',
            'order' => 25,
            'is_active' => true,
        ],
        [
            'name' => 'M. Souleymane TOURE',
            'title' => 'Membre du Directoire',
            'image' => 'membres/directoire/M. SOULEYMANE TOURE.jpg',
            'role' => 'membre_directoire',
            'group' => 'directoire',
            'order' => 26,
            'is_active' => true,
        ],
    ];

    // Ajouter les membres du secrétariat exécutif
    foreach ($secretariatMembers as $member) {
        // Vérifier si le membre existe déjà
        $existingMember = OrganizationStructure::where('name', $member['name'])
            ->where('group', 'secretariat_executif')
            ->first();
        
        if (!$existingMember) {
            OrganizationStructure::create($member);
            echo "Membre ajouté: {$member['name']}\n";
        } else {
            echo "Membre déjà existant: {$member['name']}\n";
        }
    }

    // Ajouter les membres du directoire
    foreach ($directoireMembers as $member) {
        // Vérifier si le membre existe déjà
        $existingMember = OrganizationStructure::where('name', $member['name'])
            ->where('group', 'directoire')
            ->first();
        
        if (!$existingMember) {
            OrganizationStructure::create($member);
            echo "Membre ajouté: {$member['name']}\n";
        } else {
            echo "Membre déjà existant: {$member['name']}\n";
        }
    }

    // Valider les modifications
    DB::commit();
    echo "Tous les membres ont été ajoutés avec succès!\n";
} catch (\Exception $e) {
    // Annuler les modifications en cas d'erreur
    DB::rollBack();
    echo "Erreur lors de l'ajout des membres: " . $e->getMessage() . "\n";
}
