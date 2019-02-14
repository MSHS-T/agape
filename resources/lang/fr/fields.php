<?php

return [
    "first_name" => "Prénom",
    "last_name" => "Nom",
    "name" => "Nom",
    "email" => "Adresse e-mail",
    "phone" => "Téléphone",
    "coordinates" => "Coordonnées",
    "password" => "Mot de passe",
    "password_confirmation" => "Confirmation du mot de passe",
    "remember_me" => "Se souvenir de moi",
    "id" => "ID",
    "actions" => "Actions",
    "creation_date" => "Création",
    "modification_date" => "Dernière modification",
    "submission_date" => "Date de soumission",
    "other" => "Autre",
    "none" => "Aucun",
    "error" => "Erreur",
    "status" => "Statut",
    "download_link" => "Lien de téléchargement",
    "upload_overwrite" => "Si vous avez déjà soumis un fichier pour ce champ, vous pouvez le contrôler à l'aide du lien ci dessus.<br/>Si vous envoyez un nouveau fichier, l'ancien sera écrasé. Laissez ce champ vide pour conserver le fichier déjà présent.",
    "upload_overwrite_multiple" => "Ce champ accepte plusieurs fichiers.<br/>Si vous avez déjà soumis un ou plusieurs fichiers pour ce champ, vous pouvez les contrôler à l'aide des liens ci dessus.<br/>Si vous envoyez un ou plusieurs nouveaux fichiers, ils remplaceront <b>l'ensemble des fichiers existants</b>. Laissez ce champ vide pour conserver les fichiers déjà présents",
    "upload_extensions" => "Extensions acceptées",

    "projectcall" => [
        "type" => "Type d'appel",
        "year" => "Année",
        "title" => "Titre",
        "state" => "État",
        "calendar" => "Calendrier",
        "description" => "Présentation de l'appel à projet",
        "application_period" => "Période de candidature",
        "application" => "Candidature",
        "applicant" => "Candidat",
        "evaluation_period" => "Période d'évaluation",
        "evaluation" => "Évaluation",
        "number_of_experts" => "Nombre d'experts par dossier",
        "number_of_documents" => "Nombre maximum de documents à joindre au dossier",
        "privacy_clause" => "Clause de confidentialité",
        "invite_email_fr" => "Email d'invitation (FR)",
        "invite_email_en" => "Email d'invitation (EN)",
        "help_experts" => "Aide en ligne pour les experts",
        "help_candidates" => "Aide en ligne pour les candidats",
        "states" => [
            "open" => "En cours",
            "archived" => "Archivé"
        ]
    ],

    "application" => [
        "form" => [
            "section_1" => "1. Informations générales",
            "section_2" => [
                "Exploratoire" => "2. Présentation scientifique du projet",
                "Region" => "2. Présentation scientifique du projet",
                "Workshop" => "2. Présentation scientifique du workshop",
            ],
            "section_3" => [
                "Exploratoire" => "3. Budget/Financement du projet",
                "Region" => "3. Budget/Financement du projet",
                "Workshop" => "3. Budget/Financement du workshop",
            ],
            "section_4" => "4. Pièces complémentaires"
        ],
        "title" => [
            "Exploratoire" => "Intitulé du projet",
            "Region" => "Intitulé du projet",
            "Workshop" => "Intitulé du workshop",
        ],
        "acronym" => "Acronyme du projet",
        "carrier" => [
            "Exploratoire" => "Porteur/Coordinateur du projet",
            "Region" => "Porteur/Coordinateur du projet",
            "Workshop" => "Responsable du workshop",
        ],
        "laboratory_1" => "Laboratoire porteur 1",
        "laboratory_n" => "Laboratoire :index",
        "laboratories" => "Laboratoires",
        "duration" => "Durée du projet",
        "target_date" => "Date prévisionnelle du workshop",
        "study_field_n" => "Champ disciplinaire :index",
        "study_fields" => "Champs disciplinaires",
        "theme" => "Thématique générale",
        "summary_fr" => "Résumé public (FR)",
        "summary_en" => "Résumé public (EN)",
        "keyword_n" => "Mot-clé :index",
        "keywords" => "Mots-clés",
        "short_description" => [
            "Exploratoire" => "Description courte du projet",
            "Region" => "Description courte du projet",
            "Workshop" => "Description courte des objectifs du workshop",
        ],
        "short_description_help" => "Vous devrez joindre une description détaillée dans le formulaire de candidature à attacher dans la section 4",
        "amount_requested" => "Montant demandé à la MSHS-T",
        "amount_requested_help" => "Vous devrez joindre un budget précis et détaillé dans le formulaire financier à attacher dans la section 4",
        "other_fundings" => "Total des co-financements",
        "other_fundings_help" => "(ou autres soutiens financiers)",
        "total_expected_income" => "Budget prévisionnel total (recettes)",
        "total_expected_outcome" => "Budget prévisionnel total (dépenses)",
        "template" => [
            "prefix" => [
                "application" => "Formulaire de candidature",
                "financial" => "Formulaire financier"
            ],
            "suffix" => [
                "Exploratoire" => " AAP APEX",
                "Region" => " MSHS-T Région",
                "Workshop" => " AAP Workshop",
            ]
        ],
        "other_attachments" => "Pièces complémentaires"
    ],

    "carrier" => [
        "status" => "Statut (MCF/PR/CR/DR ou autre)"
    ],

    "laboratory" => [
        "unit_code" => "Code unité",
        "director_email" => "Email du directeur",
        "regency" => "Tutelle du laboratoire (CNRS, Université ou Autre)",
        "contact_name" => "Nom du contact"
    ]
];