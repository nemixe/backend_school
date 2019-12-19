<?php

return [
    'defaults' => [
        'guard' => 'employees',
        'passwords' => 'users',
    ],

    'guards' => [
        'employees' => [
            'driver' => 'jwt',
            'provider' => 'employees',
        ],
        'students' => [
            'driver' => 'jwt',
            'provider' => 'students',
        ],
    ],

    'providers' => [
        'employees' => [
            'driver' => 'eloquent',
            'model' => \App\Employee::class
        ],
        'students' => [
            'driver' => 'eloquent',
            'model' => \App\Student::class
        ]
    ]
];
