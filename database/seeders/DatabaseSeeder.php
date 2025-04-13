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

        // Ajouter les slides
        $this->call(SlideSeeder::class);

        $this->call([
            AchievementSeeder::class,
            OrganizationStructureSeeder::class,
            OrganizationMembersSeeder::class,
            ArticlesSeeder::class,
            OrganizationMemberSeeder::class,
        ]);
    }
}
