<?php

return [
    'Controllers' => [
        'Account' => [
            'AccountController.php',
            'AccountPermissionController.php'
        ],
        'Static' => [
            'TermsController.php',
            'AboutController.php'
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
        'Account' => [
            'Account.php',
            'AccountPermission.php'
        ],
        'Static' => [
            'Terms.php',
            'About.php'
        ]
    ],
    'views' => [
        'account' => [
            'login.php',
            'register.php'
        ],
        'static' => [
            'terms.php',
            'aboutUs.php'
        ]
    ]
];
