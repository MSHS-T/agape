<?php

return [
    "buttons" => [
        "pdf" => "Export PDF",
        "pdf_anon" => "Export PDF Anonymisé",
        "excel" => "Export Excel"
    ],
    "applications" => [
        "name" => "Candidatures",
        "columns" => [
            "ID",
            "AAP",
            "Acronyme",
            "Candidat",
            "Email",
            "Téléphone"
        ]
    ],
    "global" => [
        "name" => "Export_Global",
        "projectcalls" => [
            "name" => "Appels à Projets",
            "columns" => [
                "ID",
                "Type",
                "Année",
                "Titre",
                "Début des candidatures",
                "Fin des candidatures",
                "Début des évaluations",
                "Fin des évaluations",
                "Candidatures",
                "Évaluations",
                "Date de création",
                "Date de dernière modification",
                "Date d'archivage"
            ]
        ],
        "applications" => [
            "name" => "Candidatures",
            "columns" => [
                "ID",
                "Appel à Projets",
                "Acronyme",
                "Titre",
                "Porteur/Responsable",
                "Laboratoires",
                "Mots-Clés",
                "Champs Disciplinaires",
                "Évaluations",
                "Créateur",
                "Date de création",
                "Date de soumission"
            ]
        ],
        "evaluations" => [
            "name" => "Évaluations",
            "columns" => [
                "ID",
                "Appel à Projets",
                "Acronyme Candidature",
                "Expert",
                "Statut",
                "Justification",
                "Note 1",
                "Commentaire 1",
                "Note 2",
                "Commentaire 2",
                "Note 3",
                "Commentaire 3",
                "Note Globale",
                "Commentaires Globaux",
                "Date de création",
                "Date de soumission"
            ]
        ],
        "users" => [
            "name" => "Utilisateurs",
            "columns" => [
                "ID",
                "Nom",
                "Prénom",
                "E-Mail",
                "Téléphone",
                "Rôle",
                "Invité ?",
                "Bloqué ?",
                "Date d'inscription",
                "Date de dernière connexion"
            ]
        ]
    ]
];