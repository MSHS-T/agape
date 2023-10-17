<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

return new class extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->add('evaluation.grade0', 'C');
        $this->migrator->add('evaluation.grade1', 'B');
        $this->migrator->add('evaluation.grade2', 'A');
        $this->migrator->add('evaluation.grade3', 'A+');

        $this->migrator->add('evaluation.grade0Label', [
            'fr' => 'Projet à conforter (ne peut être financé)',
            'en' => 'Project to consolidate (cannot be funded)'
        ]);
        $this->migrator->add('evaluation.grade1Label', ['fr' => 'Bon projet', 'en' => 'Good project']);
        $this->migrator->add('evaluation.grade2Label', ['fr' => 'Très bon projet', 'en' => 'Very good project']);
        $this->migrator->add('evaluation.grade3Label', ['fr' => 'Excellent projet', 'en' => 'Excellent project']);

        $this->migrator->add('evaluation.notation1Title', [
            'fr' => 'Qualité et ambition scientifique du projet',
            'en' => 'Quality and scientific ambition of the project'
        ]);
        $this->migrator->add('evaluation.notation2Title', [
            'fr' => 'Organisation du projet et moyens mis en oeuvre',
            'en' => 'Project organization and means implemented'
        ]);
        $this->migrator->add('evaluation.notation3Title', [
            'fr' => 'Impact et retombées du projet',
            'en' => 'Project impact and benefits'
        ]);

        $this->migrator->add('evaluation.notation1Description', [
            'fr' => '<ul><li>Clarté des objectifs et des hypothèses de recherche</li><li>Caractère interdisciplinaire du projet et effet structurant</li><li>Caractère novateur, originalité, progrès par rapport à l\'état de l\'art</li><li>Faisabilité notamment au regard des méthodes, gestion des risques scientifiques</li></ul>',
            'en' => '<ul><li>Clarity of research objectives and hypotheses</li><li>Interdisciplinary nature of the project and structuring effect</li><li>Innovative nature, originality, progress in relation to the state of the art</li><li>Feasibility, particularly in terms of methods, and scientific risk management</li></ul>'
        ]);
        $this->migrator->add('evaluation.notation2Description', [
            'fr' => '<ul><li>Compétence, expertise et implication du coordinateur scientfiique et des partenaires</li><li>Qualité et complémentarité de l\'équipe, qualité de la collaboration</li><li>Adéquation aux objectifs des moyens mis en oeuvre et demandés (cohérence du projet)</li></ul>',
            'en' => '<ul><li>Competence, expertise and involvement of the scientific coordinator and partners</li><li>Quality and complementarity of the team, quality of collaboration</li><li>Appropriateness of the resources deployed and requested in relation to the objectives (coherence of the project)</li></ul>'
        ]);
        $this->migrator->add('evaluation.notation3Description', [
            'fr' => '<ul><li>Impact scientifique, social, économique ou culturel</li><li>Capacité du projet à répondre aux enjeux de recherche, acquisitions de nouvelles connaissances et de savoir-faire</li><li>Stratégie de diffusion et de valorisation des résultats</li></ul>',
            'en' => '<ul><li>Scientific, social, economic or cultural impact</li><li>Ability of the project to meet research challenges, acquisition of new knowledge and know-how</li><li>Strategy for disseminating and promoting results</li></ul>'
        ]);
    }
};
