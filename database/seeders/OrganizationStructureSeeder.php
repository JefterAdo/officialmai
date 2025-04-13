<?php

namespace Database\Seeders;

use App\Models\OrganizationStructure;
use Illuminate\Database\Seeder;

class OrganizationStructureSeeder extends Seeder
{
    public function run(): void
    {
        $structures = [
            [
                'name' => 'Présidence',
                'title' => 'Présidence',
                'description' => 'Direction et leadership du parti',
                'level' => 1,
                'parent_id' => null,
                'order' => 1,
                'is_active' => true,
            ],
            [
                'name' => 'Secrétariat Général',
                'title' => 'Secrétariat Général',
                'description' => 'Coordination et administration',
                'level' => 2,
                'parent_id' => 1,
                'order' => 2,
                'is_active' => true,
            ],
            [
                'name' => 'Direction Exécutive',
                'title' => 'Direction Exécutive',
                'description' => 'Mise en œuvre des décisions',
                'level' => 2,
                'parent_id' => 1,
                'order' => 3,
                'is_active' => true,
            ],
            [
                'name' => 'Conseil National',
                'title' => 'Conseil National',
                'description' => 'Organe délibératif',
                'level' => 2,
                'parent_id' => 1,
                'order' => 4,
                'is_active' => true,
            ],
            [
                'name' => 'Commissions Permanentes',
                'title' => 'Commissions Permanentes',
                'description' => 'Groupes de travail thématiques',
                'level' => 3,
                'parent_id' => 2,
                'order' => 5,
                'is_active' => true,
            ],
            [
                'name' => 'Sections Régionales',
                'title' => 'Sections Régionales',
                'description' => 'Représentation territoriale',
                'level' => 3,
                'parent_id' => 2,
                'order' => 6,
                'is_active' => true,
            ],
        ];

        foreach ($structures as $structure) {
            OrganizationStructure::create($structure);
        }
    }
} 