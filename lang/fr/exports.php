<?php

return [
    "applications" => [
        "name" => "Candidatures",

        "columnGroups" => [
            "application"  => "Candidature",
            "carrier"      => "Porteur",
            "laboratory"   => "Laboratoire :index",
            "study_fields" => "Champs Disciplinaires",
            "keywords"     => "Mot-clés",
        ],

        "columns" => [
            // Carrier
            "carrier_last_name" => "Nom du Porteur",
            "carrier_first_name" => "Prénom du Porteur",
            "carrier_status" => "Statut du Porteur",
            "carrier_email" => "Email du Porteur",
            "carrier_phone" => "Téléphone du Porteur",
            // Laboratories
            "laboratory_name" => "Nom du Laboratoire :index",
            "laboratory_unit_code" => "Code Unité du Laboratoire :index",
            "laboratory_regency" => "Tutelle du Laboratoire :index",
            "laboratory_director_email" => "Directeur du Laboratoire :index",
            "laboratory_contact" => "Contact du Laboratoire :index",
            "other_laboratories" => "Autres Laboratoires et Partenaires",
            // Study Fields
            "study_field" => "Champ Disciplinaire :index",
            // Keywords
            "keyword" => "Mot-clé :index",
        ]
    ],
];
