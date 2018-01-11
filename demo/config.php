<?php

$oauthConfigs = [
    Tistre\SimpleOAuthLogin\Login::SERVICE_GITHUB => [
        'providerParams' => [
            'clientId' => '...',
            'clientSecret' => '...',
            'redirectUri' => 'https://www.example.com/oauth_demo/oauth_login.php/github'
        ],
        'authorizationUrlParams' => [
            'state' => 'OPTIONAL_CUSTOM_CONFIGURED_STATE',
            'scope' => ['user:email']
        ]
    ],
    Tistre\SimpleOAuthLogin\Login::SERVICE_GOOGLE => [
        'providerParams' => [
            'clientId' => '...',
            'clientSecret' => '...',
            'redirectUri' => 'https://www.example.com/oauth_demo/oauth_login.php/google',
            'hostedDomain' => 'https://www.example.com'
        ]
    ],
    Tistre\SimpleOAuthLogin\Login::SERVICE_LINKEDIN => [
        'providerParams' => [
            'clientId' => '...',
            'clientSecret' => '...',
            'redirectUri' => 'https://www.example.com/oauth_demo/oauth_login.php/linkedin'
        ],
        'authorizationUrlParams' => [
            'state' => 'OPTIONAL_CUSTOM_CONFIGURED_STATE',
            'scope' => ['r_basicprofile', 'r_emailaddress']
        ]
    ],
    Tistre\SimpleOAuthLogin\Login::SERVICE_MICROSOFT => [
        'providerParams' => [
            'clientId' => '...',
            'clientSecret' => '...',
            'redirectUri' => 'https://www.example.com/oauth_demo/oauth_login.php/microsoft',
            'urlAuthorize' => 'https://login.microsoftonline.com/common/oauth2/v2.0/authorize',
            'urlAccessToken' => 'https://login.microsoftonline.com/common/oauth2/v2.0/token',
            'urlResourceOwnerDetails' => '',
            'scopes' => 'openid User.Read'
        ]
    ]
];
