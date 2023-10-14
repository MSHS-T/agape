<?php

return [
    /**
     * Role list
     */
    'roles' => [
        'administrator',
        'manager',
        'expert',
        'applicant',
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
            'label' => ['fr' => 'Générique', 'en' => 'Generic'],
            'extra_attributes' => [
                'duration' => ['fr' => 'Durée', 'en' => 'Duration'],
            ],
            'rules' => [
                'duration' => ['required', 'string']
            ]
        ],
        'workshop' => [
            'label' => ['fr' => 'Workshop', 'en' => 'Workshop'],
            'extra_attributes' => [
                'target_date' => ['fr' => 'Dates Prévisionnelles', 'en' => 'Target Dates'],
            ],
            'rules' => [
                'target_date'   => ['required', 'array', 'min:0'],
                'target_date.*' => ['date'],
            ]
        ]
    ]
];
