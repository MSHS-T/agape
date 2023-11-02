<?php

namespace Database\Seeders;

use App\Models\ProjectCallType;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProjectCallTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ProjectCallType::create([
            'reference' => 'RG',
            'label_short' => [
                'fr' => 'Appel Coordonné',
                'en' => 'Coordinated Call',
            ],
            'label_long' => [
                'fr' => 'Appel Coordonné MSHST-Région Occitanie',
                'en' => 'Coordinated Call MSHST-Occitanie Region',
            ],
            'dynamic_attributes' => 'generic',
        ])->managers()->attach(User::role('manager')->first());
        ProjectCallType::create([
            'reference' => 'EX',
            'label_short' => [
                'fr' => 'APEX',
                'en' => 'APEX',
            ],
            'label_long' => [
                'fr' => 'Appel à Projets Exploratoire',
                'en' => 'Exploratory Project Call',
            ],
            'dynamic_attributes' => 'generic',
        ])->managers()->attach(User::role('manager')->first());
        ProjectCallType::create([
            'reference' => 'WS',
            'label_short' => [
                'fr' => 'Workshop/Réseau de Recherche',
                'en' => 'Workshop/Research Network',
            ],
            'label_long' => [
                'fr' => 'Appel à Projets Workshop/Réseau de Recherche',
                'en' => 'Workshop/Research Network Project Call',
            ],
            'dynamic_attributes' => 'workshop',
        ]);
    }
}
