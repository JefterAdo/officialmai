<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // D'abord créer les rôles et permissions
        $this->call(RolesAndPermissionsSeeder::class);
        
        // Ensuite créer l'administrateur
        $this->call(AdminUserSeeder::class);

        // Ajouter les catégories avant les actualités
        $this->call(CategoriesSeeder::class);
        
        // Ajouter les slides
        $this->call(SlideSeeder::class);

        $this->call([
            AchievementSeeder::class,
            OrganizationStructureSeeder::class,
            OrganizationMembersSeeder::class,
            ArticlesSeeder::class,
            NewsSeeder::class, // Ajout du seeder des actualités
            OrganizationMemberSeeder::class,
            DocumentsSeeder::class,
            EventsSeeder::class,
            SpeechesSeeder::class,
        ]);
        
        // Mettre à jour les identifiants administrateur
        $this->call(UpdateAdminCredentials::class);
    }
}
