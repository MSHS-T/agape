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
];
