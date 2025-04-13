<?php

namespace Database\Seeders;

use App\Models\Achievement;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AchievementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $achievements = [
            [
                'title' => 'Infrastructures',
                'icon' => 'fas fa-road-bridge',
                'description' => 'Routes, ponts, et projets structurants.',
                'order' => 1,
                'is_active' => true,
            ],
            [
                'title' => 'Éducation',
                'icon' => 'fas fa-school',
                'description' => 'Construction et réhabilitation d\'écoles.',
                'order' => 2,
                'is_active' => true,
            ],
            [
                'title' => 'Santé',
                'icon' => 'fas fa-hospital',
                'description' => 'Accès aux soins et couverture maladie.',
                'order' => 3,
                'is_active' => true,
            ],
            [
                'title' => 'Économie',
                'icon' => 'fas fa-chart-pie',
                'description' => 'Croissance soutenue et investissements.',
                'order' => 4,
                'is_active' => true,
            ],
            [
                'title' => 'Sécurité',
                'icon' => 'fas fa-shield-halved',
                'description' => 'Paix retrouvée et sécurité renforcée.',
                'order' => 5,
                'is_active' => true,
            ],
            [
                'title' => 'Emploi',
                'icon' => 'fas fa-briefcase',
                'description' => 'Programmes pour l\'emploi des jeunes.',
                'order' => 6,
                'is_active' => true,
            ],
        ];

        foreach ($achievements as $achievement) {
            Achievement::create($achievement);
        }
    }
}