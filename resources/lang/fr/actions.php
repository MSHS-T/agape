<?php

return [
    "login"               => "Connexion",
    "logout"              => "Déconnexion",
    "register"            => "Inscription",
    "registered"          => "Compte utilisateur créé",
    "send_reset_password" => "Envoyer le lien de réinitialisation",
    "reset_password"      => "Réinitialiser le mot de passe",
    "toggle_navigation"   => "Afficher le menu",
    "back"                => "Retour",
    "show"                => "Visualiser",
    "create"              => "Créer",
    "save"                => "Enregistrer",
    "edit"                => "Modifier",
    "delete"              => "Supprimer",
    "cancel"              => "Annuler",
    "archive"             => "Archiver",
    "unarchive"           => "Restaurer",
    "close"               => "Fermer",
    "submit"              => "Soumettre",
    "home"                => "Accueil",
    "add"                 => "Ajouter",
    "accept"              => "Accepter",
    "decline"             => "Refuser",
    "download"            => "Télécharger",
    "send"                => "Envoyer",
    "select_element"      => "Sélectionner un élément (taper du texte pour filtrer)",
    "select_elements"     => "Sélectionner des éléments (taper du texte pour filtrer)",
    "add_element"         => "Ajouter un nouvel élément",
    "edit_profile"        => "Edition du profil utilisateur",
    "edit_password"       => "Modification du mot de passe",
    "edit_password_help"  => "Si vous ne souhaitez pas changer votre mot de passe, laissez les 2 champs vides",
    "profile_edited"      => "Profil utilisateur modifié",
    "export_pdf"          => "Export PDF",
    "export_pdf_anon"     => "Export PDF Anonymisé",
    "make_public"         => "Rendre public",
    "contact"             => "Contact",
    "contact_sent"        => "Votre message a bien été envoyé aux administrateurs.",
    "globalExport"        => "Export Global",
    "credits"             => "Crédits : Danièle DATTAS - Université Toulouse Jean Jaurès",

    "confirm_archive" => [
        "title" => "Confirmer l'archivage",
        "body"  => "Êtes-vous sûr de vouloir archiver cet élément ?"
    ],

    "confirm_delete" => [
        "title" => "Confirmer la suppression",
        "body"  => "Êtes-vous sûr de vouloir supprimer cet élément ? Cette action est irréversible."
    ],

    "confirm_block" => [
        "title" => "Confirmer le (dé)bloquage",
        "body"  => "Êtes-vous sûr de vouloir bloquer/débloquer cet utilisateur ?"
    ],

    "confirm_decline" => [
        "title" => "Confirmer le refus",
        "body"  => "Veuillez saisir la raison de votre refus. Attention : cette action est irréversible.",
        "error" => "Erreur : la justification de votre refus est obligatoire"
    ],

    "profile"        => "Mon profil",
    "administration" => "Administration",
    "laboratories"   => "Laboratoires",
    "study_fields"   => "Champs disciplinaires",

    "projectcall" => [
        "show"                 => "Visualiser l'appel à Projets",
        "list"                 => "Appels à Projets",
        "listopen"             => "Appels à Projets en cours",
        "listold"              => "Appels à Projets terminés",
        "create"               => "Nouvel Appel à Projets",
        "created"              => "L'appel à projets a bien été créé.",
        "edit"                 => "Modifier l'Appel à Projets",
        "edited"               => "L'appel à projets a bien été modifié.",
        "deleted"              => "L'appel à projets a bien été supprimé.",
        "apply"                => "Déposer une candidature",
        "empty"                => "Aucun Appel à Projets à afficher",
        "cannot_apply_anymore" => "Il n'est plus possible de candidater sur cet appel à projets",
        "cannot_evaluate_anymore" => "Il n'est plus possible d'évaluer les candidatures de cet appel à projets"
    ],

    "application" => [
        "list"               => "Candidatures",
        "list_count"         => "Candidatures (:count)",
        "mylist"             => "Mes Candidatures",
        "show"               => "Visualiser ma candidature",
        "show_a"             => "Visualiser une candidature",
        "show_all"           => "Visualiser les candidatures (:count)",
        "edit"               => "Saisir ma candidature",
        "submit"             => "Soumettre ma candidature",
        "confirm_submission" => [
            "title"         => "Confirmer la soumission",
            "body"          => "Êtes-vous sur de vouloir soumettre votre candidature ? Cette action est définitive",
            "error_unsaved" => "Vous devez d'abord sauvegarder votre candidature avant de pouvoir la soumettre."
        ],
        "saved"                   => "Votre candidature a été sauvegardée. Pensez à la soumettre avant la date limite.",
        "submitted"               => "Votre candidature a été soumise avec succès.",
        "already_submitted"       => "Votre candidature a déjà été soumise et ne peut plus être modifiée.",
        "experts"                 => "Experts",
        "evaluations"             => "Évaluations",
        "assignations"           => "Affectation des experts",
        "assign_expert"           => "Affecter un expert",
        "expert_assigned"         => "La demande d'évaluation a été transmise à l'expert",
        "expert_unassigned"       => "La demande d'évaluation a été annulée",
        "expert_already_assigned" => "L'expert est déjà affecté à cette candidature",
    ],

    "evaluationoffers" => [
        "offer_count"    => "Propositions d'évaluation (:count)",
        "accepted_count" => "Évaluations à réaliser (:count)",
        "done_count"     => "Évaluations terminées (:count)",
        "accepted"       => "Proposition d'évaluation acceptée.",
        "declined"       => "Proposition d'évaluation refusée.",
        "retry"          => "Envoyer un rappel",
        "reminder_sent"  => "Un rappel a été envoyé à l'expert",
        "empty"          => "Aucune évaluation présente dans la base de données..."
    ],

    "evaluation" => [
        "evaluate"         => "Évaluer",
        "list_count"       => "Évaluations (:count)",
        "show_all"         => "Visualiser les evaluations (:count)",
        "create"           => "Evaluer la candidature",
        "show"             => "Visualiser l'évaluation",
        "call_data"        => "Détails de l'appel à projets",
        "application_data" => "Détails de la candidature",
        "evaluation_form"  => "Formulaire d'évaluation",
        "submit"           => "Soumettre l'évaluation",
        "saved"                   => "Votre évaluation a été sauvegardée. Pensez à la soumettre avant la date limite.",
        "submitted"               => "Votre évaluation a été soumise avec succès.",
        "already_submitted"       => "Votre évaluation a déjà été soumise et ne peut plus être modifiée.",
        "confirm_submission" => [
            "title"         => "Confirmer la soumission",
            "body"          => "Êtes-vous sur de vouloir soumettre cette évaluation ? Cette action est définitive",
            "error_unsaved" => "Vous devez d'abord sauvegarder cette évaluation avant de pouvoir la soumettre."
        ],
        "export_name"      => "Grille d'Évaluation"
    ],

    "settings" => [
        "list"     => "Paramètres",
        "saved"    => "Les paramètres ont bien été sauvegardés.",
        "sections" => [
            "projectcalls"         => "Configuration des appels à projets",
            "notation_guide"       => "Guide de notation",
            "notation_description" => "Description des notes"
        ]
    ],

    "laboratory" => [
        "list" => "Laboratoires",
        "create"   => "Nouveau Laboratoire",
        "created"  => "Le Laboratoire a bien été créé.",
        "edit"     => "Modifier le Laboratoire",
        "edited"   => "Le Laboratoire a bien été modifié.",
        "deleted"  => "Le Laboratoire a bien été supprimé.",
    ],

    "studyfield" => [
        "list" => "Champs Disciplinaires",
        "create"   => "Nouveau Champ Disciplinaire",
        "created"  => "Le Champ Disciplinaire a bien été créé.",
        "edit"     => "Modifier le Champ Disciplinaire",
        "edited"   => "Le Champ Disciplinaire a bien été modifié.",
        "deleted"  => "Le Champ Disciplinaire a bien été supprimé.",
    ],

    "user" => [
        "list" => "Utilisateurs",
        "invite" => "Inviter un Utilisateur",
        "invited" => "L'invitation a bien été envoyée.",
        "block" => "Bloquer",
        "unblock" => "Débloquer",
        "blocked" => "L'Utilisateur a bien été bloqué",
        "unblocked" => "L'Utilisateur a bien été débloqué"
    ],

    "error" => [
        "title"        => "Une erreur s'est produite :",
        "unauthorized" => "Vous n'avez pas la permission d'accéder à cette page.<br/>Profils autorisés : :roles.",
        "not_found"    => "La page demandée n'a pas pu être trouvée.",
        "unknown"      => "Erreur inconnue. Veuillez contacter l'administrateur du site si l'erreur se reproduit."
    ]
];