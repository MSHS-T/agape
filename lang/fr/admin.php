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
        'blocked_filter'             => 'Etat de blocage',
        'all'                        => 'Tous',
        'unblocked'                  => 'Non Bloqués',
        'blocked'                    => 'Bloqués',
        'invite_user'                => 'Inviter un utilisateur',
        'invitation_language'        => 'Langue de l\'invitation',
        'invitation_language_all'    => 'Toutes',
        'invitation_duplicate_email' => 'L\'email saisi est déjà présent dans la base de données des utilisateurs ou des invitations.',
        'invitation_error'           => 'Une erreur est survenue lors de l\'envoi de l\'invitation :',
        'invitation_success'         => 'L\'invitation a été envoyée avec succès.',
    ],

    'invitations' => [
        'invitations_title' => 'Invitations en attente',
        'last_mail'         => 'Date de dernier envoi',
        'retry_count'       => 'Nombre de relances',
        'retry'             => 'Renvoyer',
        'cancel'            => 'Annuler',
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
    'default_number_help'  => 'Si cette valeur est mise à zéro, le champ correspondant du formulaire de candidature sera caché.',
    'never'                => 'Jamais',
    'unsubmit'             => 'Dévalider',
    'force_submit'         => 'Soumettre manuellement',
    'submission_status'    => [
        'draft'       => 'Brouillon',
        'submitted'   => 'Soumise',
        'devalidated' => 'Dévalidée',
    ],

    'application' => [
        'offers'          => 'Experts (:count)',
        'evaluations'     => 'Évaluations (:count)',
        'add_expert'      => 'Ajouter un expert',
        'existing_expert' => 'Expert déjà enregistré',
        'new_expert'      => 'Email de l\'expert à inviter',
    ],

    'evaluation_offer' => [
        'list_title'        => 'Offres d\'évaluation pour la candidature :application',
        'rejection_title'   => 'Offre d\'évaluation refusée pour la raison suivante :',
        'status'            => [
            'accepted' => 'Acceptée',
            'rejected' => 'Refusée',
            'pending'  => 'En attente',
        ],
        'retries'     => 'Relances',
        'retry'       => 'Envoyer un rappel',
        'cancel'      => 'Annuler',
        'show_reason' => 'Raison du refus',

        'success_sent'             => 'Une proposition d\'évaluation vient d\'être envoyée à l\'expert choisi.',
        'success_invited'          => 'Une invitation à rejoindre la plateforme vient d\'être envoyée à l\'expert choisi.',
        'success_linked'           => 'L\'expert choisi a déjà été invité mais n\'a pas encore rejoint la plateforme. La proposition d\'évaluation a été liée à son invitation et une notification lui a été envoyée.',
        'error_no_expert_or_email' => 'Vous devez choisir un expert ou saisir une adresse e-mail pour envoyer une invitation.',
    ],

    'evaluation' => [
        'list_title' => 'Évaluations pour la candidature :application',
        'show_title' => 'Évaluation de la candidature :application par :expert',
        'status'     => [
            'accepted' => 'Acceptée',
            'rejected' => 'Refusée',
            'pending'  => 'En attente',
        ],
        'grades'      => 'Notes',
        'retries'     => 'Relances',
        'retry'       => 'Envoyer un rappel',
        'cancel'      => 'Annuler',
        'show_reason' => 'Raison du refus',
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
            'forbiddenDomains'             => 'Domaines d\'email interdits pour les inscriptions',
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
