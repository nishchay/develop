<?php

return [
    'Account' => [
        'Controllers' => [
            'AccountController.php'
        ],
        'Models' => [
            'AccountModel.php',
            'StaticModel.php'
        ],
        'Entities' => [
            'User.php',
            'UserPermission.php'
        ],
        'views' => [
            'login.php',
            'register.php',
        ]
    ],
    'Static' => [
        'Controllers' => [
            'StaticController.php'
        ],
        'Models' => [
            'StaticModel.php'
        ],
        'Entities' => [
            'StaticContent.php'
        ],
        'views' => [
            'static' => [
                'terms.php',
                'cookies.php'
            ]
        ]
    ]
];
