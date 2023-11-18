<?php

return [
    // Project Call
    'project_call_type'      => 'Type d\'Appel',
    'year'                   => 'Année',
    'application_start_date' => 'Début de candidature',
    'application_end_date'   => 'Fin de candidature',
    'evaluation_start_date'  => 'Début d\'expertise',
    'evaluation_end_date'    => 'Fin d\'expertise',
    'privacy_clause'         => 'Clause de confidentialité',
    'invite_email'           => 'Email d\'invitation',
    'help_experts'           => 'Aide en ligne Experts',
    'help_candidates'        => 'Aide en ligne Candidats',
    'notation'               => 'Guide d\'évaluation',
    'number_of_documents'    => 'Nombre maximum de documents',
    'number_of_laboratories' => 'Nombre maximum de laboratoires',
    'number_of_study_fields' => 'Nombre maximum de champs disciplinaires',
    'number_of_keywords'     => 'Nombre maximum de mots clés',
    'accepted_extensions'    => 'Extensions acceptées : :extensions',
    'files'                  => [
        'applicationForm'        => 'Formulaire de Candidature',
        'financialForm'          => 'Formulaire Financier',
        'additionalInformation'  => 'Informations complémentaires',
        'otherAttachments'       => 'Autres Fichiers',
    ],
    'project_call_status' => [
        'planned'                => 'Prévu',
        'application'            => 'Candidature',
        'waiting_for_evaluation' => 'Pré-expertise',
        'evaluation'             => 'Expertise',
        'waiting_for_decision'   => 'Comité d\'Attribution',
        'finished'               => 'Terminé',
        'archived'               => 'Archivé',
    ],

    // Application
    'acronym'                => 'Acronyme',
    'short_description'      => 'Description courte',
    'summary_fr'             => 'Résumé public (FR)',
    'summary_en'             => 'Résumé public (EN)',
    'carrier'                => 'Porteur/Coordinateur du projet',
    'other_laboratories'     => 'Autres Laboratoires et Partenaires',
    'keywords'               => 'Mots-clés',
    'amount_requested'       => 'Montant demandé à la MSHS-T',
    'other_fundings'         => 'Total des co-financements',
    'total_expected_income'  => 'Budget prévisionnel total (recettes)',
    'total_expected_outcome' => 'Budget prévisionnel total (dépenses)',

    // Project Call Type
    'label_long'         => 'Label long',
    'label_short'        => 'Label court',
    'dynamic_attributes' => [
        'title'       => 'Propriétés dynamiques',
        'label'       => 'Intitulé du champ (traduit)',
        'location'    => 'Emplacement',
        'section'     => 'Section',
        'after_field' => 'Après le champ',
        'type'        => 'Type de champ',
        'types'       => [
            'text'     => 'Texte court',
            'date'     => 'Date',
            'richtext' => 'Zone de texte avec mise en forme',
            'textarea' => 'Zone de texte',
            'checkbox' => 'Cases à cocher',
            'select'   => 'Liste déroulante',
        ]
    ],

    // Laboratory
    'unit_code'      => 'Code Unité',
    'director_email' => 'Email du directeur',
    'regency'        => 'Tutelle du laboratoire (CNRS, Université ou Autre)',

    // User
    'first_name'     => 'Prénom',
    'last_name'      => 'Nom',
    'email'          => 'Adresse e-mail',
    'phone'          => 'Téléphone',
    'role'           => 'Rôle',
    'email_verified' => 'Email vérifié ?',
    'last_active_at' => 'Dernière connexion',
    'managed_types'  => 'Types d\'AAP gérés',

    // Generic
    'name'        => 'Nom',
    'title'       => 'Titre',
    'description' => 'Description',
    'status'      => 'Statut',
    'reference'   => 'Référence',
    'creator'     => 'Créateur',
    'created_at'  => 'Date de création',
    'updated_at'  => 'Date de mise à jour',
];
