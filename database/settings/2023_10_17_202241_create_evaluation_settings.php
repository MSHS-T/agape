<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

return new class extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->add('general.grades', [
            [
                'grade' => 'C',
                'label' => [
                    'fr' => 'Projet à conforter (ne peut être financé)',
                    'en' => 'Project to consolidate (cannot be funded)'
                ]
            ],
            [
                'grade' => 'B',
                'label' => ['fr' => 'Bon projet', 'en' => 'Good project']
            ],
            [
                'grade' => 'A',
                'label' => ['fr' => 'Très bon projet', 'en' => 'Very good project']
            ],
            [
                'grade' => 'A+',
                'label' => ['fr' => 'Excellent projet', 'en' => 'Excellent project']
            ]
        ]);
        $this->migrator->add('general.notation', [
            [
                'title' => [
                    'fr' => 'Qualité et ambition scientifique du projet',
                    'en' => 'Quality and scientific ambition of the project'
                ],
                'description' => [
                    'fr' => '<ul><li>Clarté des objectifs et des hypothèses de recherche</li><li>Caractère interdisciplinaire du projet et effet structurant</li><li>Caractère novateur, originalité, progrès par rapport à l\'état de l\'art</li><li>Faisabilité notamment au regard des méthodes, gestion des risques scientifiques</li></ul>',
                    'en' => '<ul><li>Clarity of research objectives and hypotheses</li><li>Interdisciplinary nature of the project and structuring effect</li><li>Innovative nature, originality, progress in relation to the state of the art</li><li>Feasibility, particularly in terms of methods, and scientific risk management</li></ul>'
                ]
            ],
            [
                'title' => [
                    'fr' => 'Organisation du projet et moyens mis en oeuvre',
                    'en' => 'Project organization and means implemented'
                ],
                'description' => [
                    'fr' => '<ul><li>Compétence, expertise et implication du coordinateur scientfiique et des partenaires</li><li>Qualité et complémentarité de l\'équipe, qualité de la collaboration</li><li>Adéquation aux objectifs des moyens mis en oeuvre et demandés (cohérence du projet)</li></ul>',
                    'en' => '<ul><li>Competence, expertise and involvement of the scientific coordinator and partners</li><li>Quality and complementarity of the team, quality of collaboration</li><li>Appropriateness of the resources deployed and requested in relation to the objectives (coherence of the project)</li></ul>'
                ]
            ],
            [
                'title' => [
                    'fr' => 'Impact et retombées du projet',
                    'en' => 'Project impact and benefits'
                ],
                'description' => [
                    'fr' => '<ul><li>Impact scientifique, social, économique ou culturel</li><li>Capacité du projet à répondre aux enjeux de recherche, acquisitions de nouvelles connaissances et de savoir-faire</li><li>Stratégie de diffusion et de valorisation des résultats</li></ul>',
                    'en' => '<ul><li>Scientific, social, economic or cultural impact</li><li>Ability of the project to meet research challenges, acquisition of new knowledge and know-how</li><li>Strategy for disseminating and promoting results</li></ul>'
                ]
            ],
        ]);
    }
};
