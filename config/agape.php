<?php

return [
    /**
     * Role list :
     *   key = name
     *   value = can access back-office ?
     */
    'roles' => [
        'administrator' => true,
        'manager'       => true,
        'expert'        => false,
        'applicant'     => false,
    ],

    /**
     * Permission array structure :
     *   key = group
     *   value = array :
     *     key = permission
     *     value = allowed role list
     *
     * N.B. : no need to add owner since they have all permissions
     *
     * @see app/Providers/AuthServiceProvider.php
     */
    'permissions' => [
        'user' => [
            'list'   => ['manager'],
            'edit'   => ['manager'],
            'block'  => ['manager'],
        ],
    ],

    /**
     * List of enabled languages
     */
    'languages' => ['fr', 'en'],

    /*
    |--------------------------------------------------------------------------
    | Project types
    |--------------------------------------------------------------------------
    |
    | This list contains the project types that are available for the application.
    | They are defined with a label (translated in the languages enabled above),
    | specific attributes (added to the default ones) and validation rules
    |
    | Validation rules list : https://laravel.com/docs/10.x/validation#available-validation-rules
    |
    | The administrator can select one those types to the Project Call Types,
    | applying the defined settings on top of the default ones
    |
    */

    /**
     * List of project types specific to this instance
     */
    'dynamic_fields' => [
        'generic' => [
            [
                'slug'        => 'duration',
                'label'       => ['fr' => 'Durée', 'en' => 'Duration'],
                'section'     => 'general',
                'after_field' => null,
                'type'        => 'text',
                'required'    => true,
                'repeatable'  => false,
            ],
        ],
        'workshop' => [
            [
                'slug'        => 'theme',
                'label'       => ['fr' => 'Thème', 'en' => 'Theme'],
                'section'     => 'general',
                'after_field' => null,
                'type'        => 'richtext',
                'required'    => true,
                'repeatable'  => false,
            ],
            [
                'slug'        => 'target_date',
                'label'       => ['fr' => 'Dates Prévisionnelles', 'en' => 'Target Dates'],
                'section'     => 'general',
                'after_field' => null,
                'type'        => 'date',
                'repeatable'  => true,
                'minItems'    => 1,
                'maxItems'    => 5,
                'minValue'    => 'now'
            ],
        ],
        'ut' => [
            [
                'slug'        => 'thematic_pillars',
                'label'       => ['fr' => 'Pilier(s) Thématiques', 'en' => 'Thematic Pillars'],
                'section'     => 'general',
                'after_field' => 'studyFields',
                'type'        => 'checkbox',
                'options'     => [
                    [
                        'value' => 'health_and_well_being',
                        'label' => ['fr' => 'Santé et Bien-être', 'en' => 'Health and Well-being'],
                        'description' => [
                            'fr' => 'Comprendre et favoriser la vie en bonne santé et le bien-être',
                            'en' => 'Understanding and promoting healthy living and well-being',
                        ]
                    ],
                    [
                        'value' => 'societal_change_and_impacts',
                        'label' => ['fr' => 'Changements et Impacts Sociétaux', 'en' => 'Societal change and impacts'],
                        'description' => [
                            'fr' => 'Appréhender les changements globaux et leurs impacts sur les sociétés',
                            'en' => 'Understanding global changes and their impacts on society',
                        ]
                    ],
                    [
                        'value' => 'sustainable_transitions',
                        'label' => ['fr' => 'Transitions Durables', 'en' => 'Sustainable Transitions'],
                        'description' => [
                            'fr' => 'Accélérer les transitions durables : mobilité, énergie, ressources et mutations industrielles',
                            'en' => 'Accelerating sustainable transitions: mobility, energy, resources and industrial change',
                        ]
                    ]
                ]
            ],
        ]
    ]
];
