<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class OrganizationMembersSeeder extends Seeder
{
    public function run()
    {
        $now = Carbon::now();
        
        // Vice-Présidents
        $this->addMember([
            'name' => 'Mme Kandia Camara',
            'title' => 'Vice-Président',
            'image' => 'images/membres/directoire/kandia-camara.jpg',
            'group' => 'directoire',
            'role' => 'vice_president',
            'order' => 1,
        ]);

        $this->addMember([
            'name' => 'M. Abdallah Toikeusse Mabri',
            'title' => 'Vice-Président',
            'image' => 'images/membres/directoire/M. ABDALLAH TOIKEUSSE MABRI.jpg',
            'group' => 'directoire',
            'role' => 'vice_president',
            'order' => 2,
        ]);

        // Trésorier
        $this->addMember([
            'name' => 'M. Tene Birahima Ouattara',
            'title' => 'Trésorier Général',
            'image' => 'images/membres/directoire/Tene-Brahima-Ouattara.jpeg',
            'group' => 'directoire',
            'role' => 'tresorier',
            'order' => 3,
        ]);

        // Porte-paroles
        $this->addMember([
            'name' => 'M. Kouassi Kobenan Adjoumani',
            'title' => 'Porte-Parole Principal',
            'image' => 'images/membres/directoire/Kobenan_Kouassi_Adjoumani.jpg',
            'group' => 'directoire',
            'role' => 'porte_parole',
            'order' => 4,
        ]);

        $this->addMember([
            'name' => 'M. Mamadou Touré',
            'title' => 'Porte-Parole Adjoint',
            'image' => 'images/membres/directoire/mamadou-toure.jpg',
            'group' => 'directoire',
            'role' => 'porte_parole_adjoint',
            'order' => 5,
        ]);

        // Secrétaire Exécutif
        $this->addMember([
            'name' => 'M. Bacongo Ibrahima Cisse',
            'title' => 'Secrétaire Exécutif',
            'image' => 'images/membres/directoire/cisse-bacongo.webp',
            'group' => 'directoire',
            'role' => 'secretaire_executif',
            'order' => 6,
        ]);

        // Secrétaires Exécutifs Adjoints
        $secretaires = [
            [
                'name' => 'M. Hien Sie Yacouba',
                'title' => 'Chargé de l\'organisation, de l\'implantation et du suivi de la vie du Parti',
                'image' => 'images/membres/secretariat-executif/M. HIEN SIE Yacouba.jpeg',
                'order' => 1,
            ],
            [
                'name' => 'M. Emmanuel Ahoutou Koffi',
                'title' => 'Chargé de la promotion de l\'action gouvernementale',
                'image' => 'images/membres/secretariat-executif/M. Emmanuel AHOUTOU KOFFI.jpg',
                'order' => 2,
            ],
            [
                'name' => 'M. Claude Sahi',
                'title' => 'Chargé des relations extérieures, de la Communication et de la Propagande',
                'image' => 'images/membres/secretariat-executif/M. Claude SAHI.jpeg',
                'order' => 3,
            ],
            [
                'name' => 'M. Doumbia Brahima',
                'title' => 'Chargé du processus électoral',
                'image' => 'images/membres/secretariat-executif/M. DOUMBIA Brahima.jpg',
                'order' => 4,
            ],
            [
                'name' => 'Mme Maférima Diarrassouba',
                'title' => 'Chargée de la Cohésion et de la Solidarité',
                'image' => 'images/membres/secretariat-executif/Mme Maférima DIARRASSOUBA.jpg',
                'order' => 5,
            ],
            [
                'name' => 'Pr. Justin N\'Goran Koffi',
                'title' => 'Chargé de la formation et de l\'Institut Politique du Parti',
                'image' => 'images/membres/secretariat-executif/Pr. Justin NGORAN KOFFI.jpg',
                'order' => 6,
            ]
        ];

        foreach ($secretaires as $secretaire) {
            $this->addMember(array_merge($secretaire, [
                'group' => 'secretariat_executif',
                'role' => 'secretaire_executif_adjoint',
            ]));
        }

        // Chargés de missions
        $charges = [
            [
                'name' => 'M. Félix Anoblé',
                'title' => 'Chargé de la Stratégie Électorale',
                'image' => 'images/membres/directoire/felix-anoble.jpg',
                'order' => 7,
            ],
            [
                'name' => 'M. Ali Kader Coulibaly',
                'title' => 'Chargé de la Stratégie d\'Organisation et d\'Implantation du Parti',
                'image' => 'images/membres/directoire/ali-kader-coulibaly.jpg',
                'order' => 8,
            ],
            [
                'name' => 'M. Abdramane Tiemoko Berte',
                'title' => 'Chargé de l\'Administration du Patrimoine et des Finances',
                'image' => 'images/membres/directoire/abdramane-tiemoko-berte.jpg',
                'order' => 9,
            ],
            [
                'name' => 'Mme Yao Patricia Sylvie',
                'title' => 'Chargée de la Promotion de l\'Autonomisation Financière du Militant',
                'image' => 'images/membres/directoire/yao-patricia-sylvie.jpg',
                'order' => 10,
            ],
            [
                'name' => 'Dr Adama Coulibaly',
                'title' => 'Chargée de la Promotion du Genre',
                'image' => 'images/membres/directoire/adama-coulibaly.jpg',
                'order' => 11,
            ],
        ];

        foreach ($charges as $charge) {
            $this->addMember(array_merge($charge, [
                'group' => 'directoire',
                'role' => 'charge_mission',
            ]));
        }

        // Membres
        $membres = [
            ['name' => 'M. Fidele Sarassoro', 'image' => 'images/membres/directoire/fidele-sirrasorro.jpeg'],
            ['name' => 'M. Abdourahmane Cisse', 'image' => 'images/membres/directoire/aboudramane-cisse.jpg'],
            ['name' => 'M. Ally Coulibaly', 'image' => 'images/membres/directoire/Ally coulibaly.jpg'],
            ['name' => 'M. Vagondo Diomande', 'image' => 'images/membres/directoire/vagondo-diomande.jpg'],
            ['name' => 'Mme Niale Kaba', 'image' => 'images/membres/directoire/kaba-niale.jpg'],
            ['name' => 'M. Sangafowa Coulibaly', 'image' => 'images/membres/directoire/M. SANGAFOWA COULIBALY.jpg'],
            ['name' => 'Mme Anne Desire Ouloto', 'image' => 'images/membres/directoire/anne-desire-ouloto.jpg'],
            ['name' => 'M. Amadou Kone', 'image' => 'images/membres/directoire/M. AMADOU KONE.jpg'],
            ['name' => 'M. Laurent Tchagba', 'image' => 'images/membres/directoire/laurent-tchagba.jpg'],
            ['name' => 'M. Souleymane Diarrassouba', 'image' => 'images/membres/directoire/souleymane-diarrassouba.jpg'],
            ['name' => 'M. Amadou Coulibaly', 'image' => 'images/membres/directoire/amadou-coulibaly.jpg'],
            ['name' => 'M. Pierre Dimba', 'image' => 'images/membres/directoire/pierre-dimba.jpg'],
            ['name' => 'M. Epiphane Zoro Bi Ballo', 'image' => 'images/membres/directoire/epiphane-zoro-bi-ballo.jpg'],
            ['name' => 'Mme Myss Belmonde Dogo', 'image' => 'images/membres/directoire/myss-belmonde-dogo.jpg'],
            ['name' => 'M. Adama Kamara', 'image' => 'images/membres/directoire/M. ADAMA KAMARA.jpg'],
            ['name' => 'M. Koffi N\'Guessan', 'image' => 'images/membres/directoire/M. KOFFI N\'GUESSAN.webp'],
            ['name' => 'Mme Nasseneba Toure', 'image' => 'images/membres/directoire/nasseneba-toure.jpg'],
            ['name' => 'M. Léon Adom Kacou Houadja', 'image' => 'images/membres/directoire/leon-adom-kacou-houadja.jpg'],
            ['name' => 'M. Alain Richard Donwahi', 'image' => 'images/membres/directoire/alain-donwahi.webp'],
            ['name' => 'Mme Jeanne Peuhmond', 'image' => 'images/membres/directoire/Mme JEANNE PEUHMOND.jpg'],
            ['name' => 'M. Jean-Luc Assi', 'image' => 'images/membres/directoire/M. JEAN-LUC ASSI.jpg'],
            ['name' => 'M. Célestin Serey Doh', 'image' => 'images/membres/directoire/M. CELESTIN SEREY DOH.jpeg'],
            ['name' => 'M. Gaoussou Touré', 'image' => 'images/membres/directoire/M. GAOUSSOU TOURE.jpeg'],
            ['name' => 'Mme Raymonde Goudou', 'image' => 'images/membres/directoire/Mme RAYMONDE GOUDOU.jpg'],
            ['name' => 'M. Souleymane Touré', 'image' => 'images/membres/directoire/M. SOULEYMANE TOURE.jpg'],
        ];

        foreach ($membres as $index => $membre) {
            $this->addMember(array_merge($membre, [
                'title' => 'Membre',
                'group' => 'directoire',
                'role' => 'membre',
                'order' => 12 + $index,
            ]));
        }
    }

    private function addMember(array $data)
    {
        DB::table('organization_structure')->updateOrInsert(
            ['name' => $data['name']],
            array_merge($data, [
                'is_active' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ])
        );
    }
} 