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
        $config = [
            'generic' => [
                [
                    'slug'        => 'duration',
                    'label'       => ['fr' => 'Durée', 'en' => 'Duration'],
                    'section'     => 'general',
                    'after_field' => null,
                    'type'        => 'text',
                    'required'    => true,
                    'repeatable'  => false,
                ],
            ],
            'workshop' => [
                [
                    'slug'        => 'theme',
                    'label'       => ['fr' => 'Thème', 'en' => 'Theme'],
                    'section'     => 'general',
                    'after_field' => null,
                    'type'        => 'richtext',
                    'required'    => true,
                    'repeatable'  => false,
                ],
                [
                    'slug'        => 'target_date',
                    'label'       => ['fr' => 'Dates Prévisionnelles', 'en' => 'Target Dates'],
                    'section'     => 'general',
                    'after_field' => null,
                    'type'        => 'date',
                    'repeatable'  => true,
                    'minItems'    => 1,
                    'maxItems'    => 5,
                    'minValue'    => 'now'
                ],
            ],
            'ut' => [
                [
                    'slug'        => 'thematic_pillars',
                    'label'       => ['fr' => 'Pilier(s) Thématiques', 'en' => 'Thematic Pillars'],
                    'section'     => 'general',
                    'after_field' => 'studyFields',
                    'type'        => 'checkbox',
                    'required'    => true,
                    'choices'     => [
                        [
                            'value' => 'health_and_well_being',
                            'label' => ['fr' => 'Santé et Bien-être', 'en' => 'Health and Well-being'],
                            'description' => [
                                'fr' => 'Comprendre et favoriser la vie en bonne santé et le bien-être',
                                'en' => 'Understanding and promoting healthy living and well-being',
                            ]
                        ],
                        [
                            'value' => 'societal_change_and_impacts',
                            'label' => ['fr' => 'Changements et Impacts Sociétaux', 'en' => 'Societal change and impacts'],
                            'description' => [
                                'fr' => 'Appréhender les changements globaux et leurs impacts sur les sociétés',
                                'en' => 'Understanding global changes and their impacts on society',
                            ]
                        ],
                        [
                            'value' => 'sustainable_transitions',
                            'label' => ['fr' => 'Transitions Durables', 'en' => 'Sustainable Transitions'],
                            'description' => [
                                'fr' => 'Accélérer les transitions durables : mobilité, énergie, ressources et mutations industrielles',
                                'en' => 'Accelerating sustainable transitions: mobility, energy, resources and industrial change',
                            ]
                        ]
                    ]
                ],
            ]
        ];

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
            'dynamic_attributes' => $config['generic'],
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
            'dynamic_attributes' => $config['generic'],
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
            'dynamic_attributes' => $config['workshop'],
        ]);
        ProjectCallType::create([
            'reference' => 'UT',
            'label_short' => [
                'fr' => 'TIRIS',
                'en' => 'TIRIS',
            ],
            'label_long' => [
                'fr' => 'Appel à Projets TIRIS',
                'en' => 'TIRIS Project Call',
            ],
            'dynamic_attributes' => $config['ut'],
        ]);
    }
}
