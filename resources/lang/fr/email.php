<?php

return [
    "greeting"         => "Bonjour,",
    "greeting_error"   => "Oups,",
    "regards"          => "Cordialement,",
    "signature"        => "L'équipe :app_name",
    "trouble_clicking" => "Si vous n'arrivez pas à cliquer sur le bouton \":actionText\", copiez et coller l'adresse suivante dans votre navigateur: [:actionURL](:actionURL)",

    "email_verification" => [
        "title"  => "Vérification de votre adresse email",
        "intro"  => "Veuillez cliquer sur le bouton ci-dessous pour confirmer votre adresse email.",
        "action" => "Vérifier mon adresse email",
        "outro"  => "Si vous n'avez pas créé de compte sur ce site, vous pouvez ignorer ce message."
    ],

    "reset_password" => [
        "title"  => "Demande de réinitialisation de mot de passe",
        "intro"  => "Vous recevez ce message car une réinitialisation de mot de passe a été demandée pour votre compte.",
        "action" => "Réinitialiser mon mot de passe",
        "outro"  => "Si vous n'êtes pas à l'origine de cette demande, vous pouvez ignorer ce message.",
    ],

    "new_application_submitted" => [
        "title"  => "Ajout d'une nouvelle candidature",
        "intro"  => "Le candidat :name vient de soumettre sa candidature à l'appel à projets :call.",
        "action" => "Visualiser la candidature",
    ],

    "application_submitted" => [
        "title"  => "Confirmation de candidature",
        "intro"  => "Votre candidature à l'appel à projets :call a bien été soumise sous la référence :reference.",
        "action" => "Visualiser la candidature",
    ],

    "offer_created" => [
        "title"  => "Proposition d'évaluation",
        "intro"  => "L'administrateur de la plateforme AGAPE vous a proposé d'évaluer une nouvelle candidature pour l'AAP [AAP].",
        "action" => "Répondre",
        "outro"  => "Merci de nous faire connaître votre choix dans les plus brefs délais.",
    ],

    "offer_accepted" => [
        "title" => "Proposition d'évaluation acceptée",
        "intro" => "L'expert :expert vient d'accepter la proposition d'évaluation de la candidature de :candidat pour l'appel à projets :call"
    ],

    "offer_declined" => [
        "title" => "Proposition d'évaluation refusée",
        "intro" => "L'expert :expert vient de refuser la proposition d'évaluation de la candidature de :candidat pour l'appel à projets :call",
        "outro" => "Justification du refus : :justification"
    ],

    "offer_retry" => [
        "title"  => "Rappel : Proposition d'évaluation à traiter",
        "intro"  => "Nous vous rappelons que la proposition d'évaluation de la candidature de :candidat pour l'appel à projets :call est en attente de traitement.",
        "action" => "Voir la proposition"
    ],

    "evaluation_submitted" => [
        "title" => "Évaluation envoyée",
        "intro" => "L'expert :expert vient de finaliser l'évaluation de la candidature de :candidat pour l'appel à projets :call"
    ],

    "invitation" => [
        "title"  => "Invitation à rejoindre la plateforme AGAPE",
        "intro"  => "L'administrateur de la plateforme AGAPE vous invite à rejoindre l'application en tant que :role",
        "action" => "Inscription"
    ],

    "invitation_signup" => [
        "title"  => "Inscription suite à invitation",
        "intro"  => "L'utilisateur :user, invité en tant que :role, a confirmé son inscription"
    ],

    "invitation_retry" => [
        "title"  => "Rappel : Invitation à rejoindre la plateforme AGAPE",
        "intro"  => "L'administrateur de la plateforme AGAPE vous invite à rejoindre l'application en tant que :role",
        "action" => "Inscription"
    ],

    "contact" => [
        "title"        => "Nouveau message via le formulaire de contact AGAPE",
        "intro"        => ":type :name (:email) vient d'envoyer le message suivant avec le formulaire de contact de la plateforme AGAPE: <br/>:message",
        "type_visitor" => "Le visiteur",
        "type_user"    => "L'utilisateur",
        "action"       => "Répondre"
    ]
];