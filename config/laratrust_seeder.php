<?php

return [
    /**
     * Control if the seeder should create a user per role while seeding the data.
     */
    'create_users' => false,

    /**
     * Control if all the laratrust tables should be truncated before running the seeder.
     */
    'truncate_tables' => true,

    'roles_structure' => [
        'super_admin' => [
            'users' => 'c,r,u,d',
            'teachers' => 'c,r,u,d',
            'assistants' => 'c,r,u,d',
            'subjects' => 'c,r,u,d',
            'levels' => 'c,r,u,d',
            'terms' => 'c,r,u,d',
        ],
        'admins' => [],
        'teachers' => [],
        'assistants' => [],
    ],

    'permissions_map' => [
        'c' => 'create',
        'r' => 'read',
        'u' => 'update',
        'd' => 'delete'
    ]
];
