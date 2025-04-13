<?php

namespace Database\Seeders;

use App\Models\OrganizationMember;
use App\Models\OrganizationStructure;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OrganizationMemberSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Créer les structures si elles n'existent pas
        if (OrganizationStructure::count() === 0) {
            $this->command->info('Création des structures de base...');
            
            // Directoire
            $directoire = [
                [
                    'name' => 'SEM Alassane Ouattara',
                    'title' => 'Président du RHDP',
                    'description' => 'Président du Rassemblement des Houphouëtistes pour la Démocratie et la Paix',
                    'role' => 'president',
                    'group' => 'directoire',
                    'level' => 1,
                    'order' => 1,
                ],
                [
                    'name' => 'M. Robert Beugré Mambé',
                    'title' => 'Vice-Président',
                    'role' => 'vice_president',
                    'group' => 'directoire',
                    'level' => 1,
                    'order' => 2,
                ],
                [
                    'name' => 'Mme Kandia Camara',
                    'title' => 'Vice-Présidente',
                    'role' => 'vice_president',
                    'group' => 'directoire',
                    'level' => 1,
                    'order' => 3,
                ],
            ];

            foreach ($directoire as $member) {
                OrganizationStructure::create(array_merge($member, [
                    'is_active' => true,
                ]));
            }

            // Secrétariat Exécutif
            $secretariat = [
                [
                    'name' => 'Secrétariat Exécutif Principal',
                    'title' => 'SEP',
                    'role' => 'secretaire_executif',
                    'group' => 'secretariat_executif',
                    'level' => 2,
                    'order' => 1,
                ],
                [
                    'name' => 'Secrétariat Exécutif Adjoint - Administration',
                    'title' => 'SEA-ADM',
                    'role' => 'secretaire_executif_adjoint',
                    'group' => 'secretariat_executif',
                    'level' => 2,
                    'order' => 2,
                ],
                [
                    'name' => 'Secrétariat Exécutif Adjoint - Communication',
                    'title' => 'SEA-COM',
                    'role' => 'secretaire_executif_adjoint',
                    'group' => 'secretariat_executif',
                    'level' => 2,
                    'order' => 3,
                ],
            ];

            foreach ($secretariat as $structure) {
                OrganizationStructure::create(array_merge($structure, [
                    'description' => 'Structure du secrétariat exécutif',
                    'is_active' => true,
                ]));
            }

            // Départements
            $departments = [
                [
                    'name' => 'Département des Affaires Politiques',
                    'title' => 'DAP',
                    'description' => 'Gestion des affaires politiques et stratégiques',
                    'role' => 'département',
                    'group' => 'administration',
                ],
                [
                    'name' => 'Département de la Communication',
                    'title' => 'DCOM',
                    'description' => 'Communication et relations publiques',
                    'role' => 'département',
                    'group' => 'support',
                ],
                [
                    'name' => 'Département des Relations Internationales',
                    'title' => 'DRI',
                    'description' => 'Relations internationales et coopération',
                    'role' => 'département',
                    'group' => 'administration',
                ],
            ];

            foreach ($departments as $dept) {
                OrganizationStructure::create(array_merge($dept, [
                    'level' => 3,
                    'order' => OrganizationStructure::count() + 1,
                    'is_active' => true,
                ]));
            }

            // Services
            $services = [
                [
                    'name' => 'Service Communication Digitale',
                    'title' => 'SCD',
                    'description' => 'Gestion de la présence numérique',
                    'role' => 'service',
                    'group' => 'support',
                ],
                [
                    'name' => 'Service des Événements',
                    'title' => 'SE',
                    'description' => 'Organisation des événements',
                    'role' => 'service',
                    'group' => 'support',
                ],
                [
                    'name' => 'Service Juridique',
                    'title' => 'SJ',
                    'description' => 'Affaires juridiques et contentieux',
                    'role' => 'service',
                    'group' => 'administration',
                ],
            ];

            foreach ($services as $service) {
                OrganizationStructure::create(array_merge($service, [
                    'level' => 4,
                    'order' => OrganizationStructure::count() + 1,
                    'is_active' => true,
                ]));
            }
        }

        // Créer des membres pour chaque structure
        $structures = OrganizationStructure::all();
        foreach ($structures as $structure) {
            // Nombre de membres selon le type de structure
            $numberOfMembers = match ($structure->role) {
                'service' => rand(2, 4),
                'département' => rand(3, 5),
                'secretaire_executif' => rand(1, 2),
                default => 1,
            };

            // Créer les membres
            for ($i = 0; $i < $numberOfMembers; $i++) {
                OrganizationMember::create([
                    'name' => fake()->name,
                    'position' => fake()->jobTitle,
                    'biography' => fake()->paragraphs(3, true),
                    'email' => fake()->unique()->safeEmail,
                    'phone' => fake()->phoneNumber,
                    'social_media' => [
                        'facebook' => 'https://facebook.com/' . fake()->userName,
                        'twitter' => 'https://twitter.com/' . fake()->userName,
                        'linkedin' => 'https://linkedin.com/in/' . fake()->userName,
                    ],
                    'order' => $i + 1,
                    'is_active' => true,
                    'organization_structure_id' => $structure->id,
                ]);
            }
        }

        $this->command->info('Membres de l\'organisation créés avec succès !');
    }
}
