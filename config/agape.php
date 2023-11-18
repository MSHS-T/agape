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
    'project_types' => [
        'generic' => [
            'label'            => 'Générique',
            'extra_attributes' => [
                'duration' => [
                    'label'      => ['fr' => 'Durée', 'en' => 'Duration'],
                    'type'       => 'text',
                    'repeatable' => false,
                ],
            ],
            'rules'            => [
                'duration' => ['required', 'string']
            ]
        ],
        'workshop' => [
            'label'            => 'Workshop',
            'extra_attributes' => [
                'theme' => [
                    'label'      => ['fr' => 'Thème', 'en' => 'Theme'],
                    'type'       => 'richtext',
                    'repeatable' => false,
                ],
                'target_date' => [
                    'label'      => ['fr' => 'Dates Prévisionnelles', 'en' => 'Target Dates'],
                    'type'       => 'number',
                    'repeatable' => true,
                ],
            ],
            'rules'            => [
                'target_date'   => ['required', 'array'],
                'target_date.*' => ['date', 'min:now'],
            ]
        ]
    ]
];
