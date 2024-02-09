<?php

return [
    "applications" => [
        "name" => "Applications",

        "columnGroups" => [
            "application"  => "Application",
            "carrier"      => "Carrier",
            "laboratory"   => "Laboratory :index",
            "study_fields" => "Study Fields",
            "keywords"     => "Keywords",
        ],

        "columns" => [
            // Carrier
            "carrier_last_name" => "Carrier Last Name",
            "carrier_first_name" => "Carrier First Name",
            "carrier_status" => "Carrier Status",
            "carrier_email" => "Carrier Email",
            "carrier_phone" => "Carrier Phone",
            // Laboratories
            "laboratory_name" => "Laboratory :index Name",
            "laboratory_unit_code" => "Laboratory :index Unit Code",
            "laboratory_regency" => "Laboratory :index Regency",
            "laboratory_director_email" => "Laboratory :index Director Email",
            "laboratory_contact" => "Laboratory :index Contact",
            "other_laboratories" => "Other Laboratories & Partners",
            // Study Fields
            "study_field" => "Study Field :index",
            // Keywords
            "keyword" => "Keyword :index",
        ]
    ],
];
