<?php

return [
    "yes"                       => "Oui",
    "no"                        => "Non",
    "first_name"                => "Prénom",
    "last_name"                 => "Nom",
    "name"                      => "Nom",
    "email"                     => "Adresse e-mail",
    "phone"                     => "Téléphone",
    "coordinates"               => "Coordonnées",
    "password"                  => "Mot de passe",
    "password_confirmation"     => "Confirmation du mot de passe",
    "remember_me"               => "Se souvenir de moi",
    "id"                        => "ID",
    "message"                   => "Message",
    "role"                      => "Rôle",
    "actions"                   => "Actions",
    "creator"                   => "Créateur",
    "creation_date"             => "Création",
    "modification_date"         => "Dernière modification",
    "submission_date"           => "Date de soumission",
    "other"                     => "Autre",
    "none"                      => "Aucun",
    "never"                     => "Jamais",
    "error"                     => "Erreur",
    "status"                    => "Statut",
    "comments"                  => "Commentaires",
    "reference"                 => "Référence",
    "download_link"             => "Lien de téléchargement",
    "template_download_link"    => "Formulaire à télécharger",
    "upload_overwrite"          => "Si vous avez déjà soumis un fichier pour ce champ, vous pouvez le contrôler à l'aide du lien ci dessus.<br/>Si vous envoyez un nouveau fichier, l'ancien sera écrasé. Laissez ce champ vide pour conserver le fichier déjà présent.",
    "upload_overwrite_multiple" => "Ce champ accepte plusieurs fichiers : pressez la touche Control (sous Windows/Linux) ou Command (sous Mac) pour sélectionner plusieurs fichiers lorsque vous y êtes invités.<br/>Si vous avez déjà soumis un ou plusieurs fichiers pour ce champ, vous pouvez les contrôler à l'aide des liens ci dessus.<br/>Si vous envoyez un ou plusieurs nouveaux fichiers, ils remplaceront <b>l'ensemble des fichiers existants</b>. Laissez ce champ vide pour conserver les fichiers déjà présents",
    "upload_extensions"         => "Extensions acceptées",

    "projectcall" => [
        "type"                   => "Type d'appel",
        "year"                   => "Année",
        "title"                  => "Titre",
        "state"                  => "État",
        "calendar"               => "Calendrier",
        "description"            => "Présentation de l'appel à projet",
        "application_period"     => "Période de candidature",
        "application"            => "Candidature",
        "applicant"              => "Candidat",
        "all_applicants"         => "Tous les candidats",
        "evaluation_period"      => "Période d'évaluation",
        "evaluation"             => "Évaluation",
        "number_of_experts"      => "Nombre d'experts par dossier",
        "number_of_documents"    => "Nombre maximum de documents à joindre au dossier",
        "number_of_keywords"     => "Nombre de mots-clés maximum",
        "number_of_target_dates" => "Nombre de dates prévisionnelles maximum (Workshop)",
        "number_of_laboratories" => "Nombre de laboratoires maximum",
        "number_of_study_fields" => "Nombre de champs disciplinaires maximum",
        "privacy_clause"         => "Clause de confidentialité",
        "invite_email_fr"        => "Email d'invitation Expert(FR)",
        "invite_email_en"        => "Email d'invitation Expert(EN)",
        "help_experts"           => "Aide en ligne pour les experts",
        "help_candidates"        => "Aide en ligne pour les candidats",
        "invite_email_help"      => "Vous pouvez insérer le texte [AAP] dans ce champ et il sera remplacé par le titre de l'appel à projet",
        "states"                 => [
            "open" => "En cours",
            "closed" => "Terminé",
            "archived" => "Archivé"
        ]
    ],

    "application" => [
        "form" => [
            "section_1" => "1. Informations générales",
            "section_2" => [
                "Exploratoire" => "2. Présentation scientifique du projet",
                "Region"       => "2. Présentation scientifique du projet",
                "Workshop"     => "2. Présentation scientifique du workshop",
            ],
            "section_3" => [
                "Exploratoire" => "3. Budget/Financement du projet",
                "Region"       => "3. Budget/Financement du projet",
                "Workshop"     => "3. Budget/Financement du workshop",
            ],
            "section_4" => "4. Pièces complémentaires"
        ],
        "title" => [
            "Exploratoire" => "Intitulé du projet",
            "Region"       => "Intitulé du projet",
            "Workshop"     => "Intitulé du workshop",
        ],
        "acronym" => "Acronyme du projet",
        "carrier" => [
            "Exploratoire" => "Porteur/Coordinateur du projet",
            "Region"       => "Porteur/Coordinateur du projet",
            "Workshop"     => "Responsable du workshop",
        ],
        "laboratory_1"       => "Laboratoire porteur",
        "laboratory_n"       => "Laboratoire :index",
        "laboratories"       => "Laboratoires",
        "other_laboratories" => "Autres laboratoires et partenaires",
        "duration"           => "Durée du projet",
        "target_date"        => "Date(s) prévisionnelle(s) du workshop",
        "study_fields"       => "Champ(s) disciplinaire(s)",
        "study_fields_help"  => "Vous pouvez choisir et/ou saisir jusqu'à :max éléments",
        "theme"              => "Thématique générale",
        "summary_fr"         => "Résumé public (FR)",
        "summary_en"         => "Résumé public (EN)",
        "keyword_n"          => "Mot-clé :index",
        "keywords"           => "Mots-clés",
        "short_description"  => [
            "Exploratoire" => "Description courte du projet",
            "Region"       => "Description courte du projet",
            "Workshop"     => "Description courte des objectifs du workshop",
        ],
        "short_description_help" => "Vous devrez joindre une description détaillée dans le formulaire de candidature à attacher dans la section 4",
        "amount_requested"       => "Montant demandé à la MSHS-T",
        "amount_requested_help"  => "Vous devrez joindre un budget précis et détaillé dans le formulaire financier à attacher dans la section 4",
        "other_fundings"         => "Total des co-financements",
        "other_fundings_help"    => "(ou autres soutiens financiers)",
        "total_expected_income"  => "Budget prévisionnel total (recettes)",
        "total_expected_outcome" => "Budget prévisionnel total (dépenses)",
        "template"               => [
            "prefix" => [
                "application" => "Formulaire de candidature",
                "financial"   => "Formulaire financier"
            ],
            "suffix" => [
                "Exploratoire" => " AAP APEX",
                "Region"       => " MSHS-T Région",
                "Workshop"     => " AAP Workshop",
            ]
        ],
        "other_attachments" => "Pièces complémentaires",
        "experts"           => "Experts",
    ],

    "carrier" => [
        "status" => "Statut (MCF/PR/CR/DR ou autre)",
        "email"  => ""
    ],

    "laboratory" => [
        "unit_code"      => "Code unité",
        "director_email" => "Email du directeur",
        "regency"        => "Tutelle du laboratoire (CNRS, Université ou Autre)",
        "contact_name"   => "Nom du contact"
    ],

    "offer" => [
        "expert"        => "Expert",
        "accepted"      => "Acceptée",
        "declined"      => "Refusée",
        "pending"       => "En attente",
        "done"          => "Terminée",
        "justification" => "Justification",
        "no_experts"    => "Aucun expert disponible"
    ],

    "evaluation" => [
        "grade"          => "Note",
        "global_grade"   => "Note globale",
        "global_comment" => "Commentaires globaux"
    ],

    "user" => [
        "registration_date" => "Date d'inscription",
        "last_login_date" => "Date de dernière connexion",
        "invitation_date" => "Date d'invitation",
        "blocked" => "Bloqué",
        "unblocked" => "Débloqué",
    ],

    "setting" => [
        "default_number_of_target_dates" => "Nombre par défaut de dates prévisionnelles (Workshop)",
        "default_number_of_experts"      => "Nombre par défaut d'experts",
        "default_number_of_documents"    => "Nombre par défaut de documents joints",
        "default_number_of_laboratories" => "Nombre par défaut de laboratoires",
        "default_number_of_study_fields" => "Nombre par défaut de champs disciplinaires",
        "default_number_of_keywords"     => "Nombre par défaut de mots-clés",
        "notation_title"                 => "Catégorie de notation :index",
        "notation_description"           => "Description de la catégorie :index",
        "notation_grade"                 => "Note :grade",
        "notation_details"               => "Explication",
        "extensions_application_form"    => "Extensions autorisées pour le formulaire de candidature",
        "extensions_financial_form"      => "Extensions autorisées pour le formulaire financier",
        "extensions_other_attachments"   => "Extensions autorisées pour les autres fichiers",
        "help"                           => [
            "default_value" => "Valeur par défaut pré-remplie lors de la création d'un appel à projets, modifiable individuellement dans ce dernier"
        ]
    ],
];