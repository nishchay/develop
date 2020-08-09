<?php

return [
    'Account' => [
        'Controllers' => [
            'AccountController.php',
            'AccountPermissionController.php'
        ],
        'views' => [
            'login.php',
            'register.php'
        ]
    ],
    'Static' => [
        'Controllers' => [
            'StaticController.php'
        ],
        'views' => [
            'terms.php',
            'aboutUs.php'
        ]
    ],
    'Models' => [
        'Account' => [
            'AccountModel.php',
            'AccountPermissionModel.php'
        ],
        'Static' => [
            'TermsModel.php',
            'AboutModel.php'
        ]
    ],
    'Entities' => [
        'Account.php',
        'AccountPermission.php',
        'Terms.php',
        'About.php'
    ]
];
