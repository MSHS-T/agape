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
    'languages' => explode(',', env('APP_LANGUAGES', 'fr,en')),

    /**
     * List of flags overrides (if flag code matches the language code, do not set here)
     */
    'flags' => [
        'en' => 'gb',
    ]
];
