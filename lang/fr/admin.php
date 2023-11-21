<?php

return [
    'sections' => [
        'projectcalls' => 'Appels à Projets',
        'data'         => 'Référentiels',
        'admin'        => 'Administration',
    ],

    'dashboard' => [
        'title' => 'Tableau de bord',
    ],

    'roles' => [
        'administrator' => 'Administrateur',
        'manager'       => 'Gestionnaire',
        'applicant'     => 'Candidat',
        'expert'        => 'Expert',
    ],

    'users' => [
        'blocked_filter' => 'Etat de blocage',
        'all'            => 'Tous',
        'unblocked'      => 'Non Bloqués',
        'blocked'        => 'Bloqués',
    ],

    'translatable_fields' => [
        'title'       => 'Champs multilingues',
        'description' => 'Les valeurs affichées pour ces champs seront celles dans la langue choisie par l\'utilisateur.<br/>Attention de bien saisir les valeurs pour toutes les langues configurées dans l\'application !',
    ],

    'archived_records' => [
        'label' => 'Enregistrements archivés',
        'with'  => 'Non Archivés uniquement',
        'only'  => 'Archivés uniquement',
        'all'   => 'Tous',
    ],

    'public'      => 'Public',
    'make_public' => 'Rendre public',

    'dynamic_attributes' => [
        'create'           => 'Ajouter un Champ Dynamique',
        'after_field_help' => 'Laisser vide pour ajouter le champ à la fin de la section',
        'add_option'       => 'Ajouter une option',
        'add_choice'       => 'Ajouter un choix',
    ],

    'dates'                => 'Calendrier',
    'notation_description' => 'Les critères seront présentés aux experts dans l\'ordre indiqué.',
    'files'                => 'Modèles de fichiers',
    'files_description'    => 'Ces modèles seront proposés au téléchargement aux candidats.',
    'never'                => 'Jamais',

    'application' => [
        'status' => [
            'draft'       => 'Brouillon',
            'submitted'   => 'Soumise',
            'devalidated' => 'Dévalidée',
        ],
        'unsubmit'     => 'Dévalider',
        'force_submit' => 'Soumettre manuellement',
    ],

    'settings' => [
        'title'    => 'Paramètres',

        'sections' => [
            'projectCalls'   => 'Appels à projets',
            'defaultNumbers' => 'Nombre par défaut de ...',
            'evaluation'     => 'Évaluation',
        ],

        'fields' => [
            'defaultNumberOfWorkshopDates' => 'Dates prévisionnelles (Workshop)',
            'defaultNumberOfExperts'       => 'Experts',
            'defaultNumberOfDocuments'     => 'Documents joints',
            'defaultNumberOfLaboratories'  => 'Laboratoires',
            'defaultNumberOfStudyFields'   => 'Champs disciplinaires',
            'defaultNumberOfKeywords'      => 'Mots-clés',
            'enableBudgetIncomeOutcome'    => 'Champs de budget prévisionnel total (recettes & dépenses)',
            'applicationForm'              => 'Formulaire de Candidature',
            'financialForm'                => 'Formulaire Financier',
            'additionalInformation'        => 'Informations complémentaires',
            'otherAttachments'             => 'Autres Fichiers',
            'enable'                       => 'Activer ?',
            'extensions'                   => 'Extensions Autorisées',
            'grades'                       => 'Notes',
            'gradeGrade'                   => 'Note',
            'gradeLabel'                   => 'Libellé (traduit)',
            'notation'                     => 'Critères de notation',
            'notationTitle'                => 'Intitulé du critère (traduit)',
            'notationDescription'          => 'Description du critère (traduit)',
        ],

        'description' => [
            'grades'   => 'La première note est la plus basse, la dernière la plus haute',
            'notation' => 'Ces critères de notation sont les valeurs par défaut de chaque Appel à Projet. Ils seront présentés aux experts dans l\'ordre indiqué.'
        ],
        'actions' => [
            'addGrade'    => 'Ajouter une note',
            'addNotation' => 'Ajouter un critère',
        ],
    ]
];
