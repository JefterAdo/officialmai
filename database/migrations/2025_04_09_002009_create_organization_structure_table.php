<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('organization_structure', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('image')->nullable();
            $table->string('role')->default('member');
            $table->string('group')->default('directoire');
            $table->integer('level')->default(1);
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->integer('order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            
            $table->foreign('parent_id')
                ->references('id')
                ->on('organization_structure')
                ->onDelete('set null');
        });

        // Insertion des données par défaut
        $defaultMembers = [
            [
                'name' => 'SEM Alassane Ouattara',
                'title' => 'Président du RHDP',
                'image' => 'images/membres/Alassane_Outtara.png',
                'role' => 'president',
                'group' => 'directoire',
                'order' => 1,
            ],
            [
                'name' => 'M. Robert Beugré Mambé',
                'title' => 'Vice-Président',
                'image' => 'images/membres/directoire/beugre.webp',
                'role' => 'vice_president',
                'group' => 'directoire',
                'order' => 2,
            ],
            [
                'name' => 'Mme Kandia Camara',
                'title' => 'Vice-Présidente',
                'image' => 'images/membres/directoire/kandia-camara.jpg',
                'role' => 'vice_president',
                'group' => 'directoire',
                'order' => 3,
            ],
            [
                'name' => 'M. Abdallah Toikeusse Mabri',
                'title' => 'Vice-Président',
                'image' => 'images/membres/directoire/M. ABDALLAH TOIKEUSSE MABRI.jpg',
                'role' => 'vice_president',
                'group' => 'directoire',
                'order' => 4,
            ],
            [
                'name' => 'M. Tene Birahima Ouattara',
                'title' => 'Trésorier Général',
                'image' => 'images/membres/directoire/Tene-Brahima-Ouattara.jpeg',
                'role' => 'tresorier',
                'group' => 'directoire',
                'order' => 5,
            ],
            [
                'name' => 'M. Kouassi Kobenan Adjoumani',
                'title' => 'Porte-Parole Principal',
                'image' => 'images/membres/directoire/Kobenan_Kouassi_Adjoumani.jpg',
                'role' => 'porte_parole',
                'group' => 'directoire',
                'order' => 6,
            ],
            [
                'name' => 'M. Mamadou Touré',
                'title' => 'Porte-Parole Adjoint',
                'image' => 'images/membres/directoire/mamadou-toure.jpg',
                'role' => 'porte_parole_adjoint',
                'group' => 'directoire',
                'order' => 7,
            ],
            [
                'name' => 'M. Bacongo Ibrahima Cisse',
                'title' => 'Secrétaire Exécutif',
                'image' => 'images/membres/directoire/cisse-bacongo.webp',
                'role' => 'secretaire_executif',
                'group' => 'directoire',
                'order' => 8,
            ],
            [
                'name' => 'M. Félix Anoblé',
                'title' => 'Chargé de la Stratégie Électorale',
                'image' => 'images/membres/directoire/felix-anoble.jpg',
                'role' => 'charge_mission',
                'group' => 'directoire',
                'order' => 9,
            ],
        ];

        foreach ($defaultMembers as $member) {
            DB::table('organization_structure')->insert(array_merge($member, [
                'created_at' => now(),
                'updated_at' => now(),
                'is_active' => true,
            ]));
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('organization_structure');
    }
};
