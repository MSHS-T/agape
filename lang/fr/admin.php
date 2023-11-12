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

    'translatable_fields' => 'Champs multilingues',

    'public'      => 'Public',
    'make_public' => 'Rendre public',

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
            'notation' => 'Ces critères de notation sont les valeurs par défaut de chaque Appel à Projet. Ils seront présentés dans l\'ordre indiqué aux experts.'
        ],
        'actions' => [
            'addGrade'    => 'Ajouter une note',
            'addNotation' => 'Ajouter un critère',
        ],
    ]
];
