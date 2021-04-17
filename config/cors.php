<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Cross-Origin Resource Sharing (CORS) Configuration
    |--------------------------------------------------------------------------
    |
    | Here you may configure your settings for cross-origin resource sharing
    | or "CORS". This determines what cross-origin operations may execute
    | in web browsers. You are free to adjust these settings as needed.
    |
    | To learn more: https://developer.mozilla.org/en-US/docs/Web/HTTP/CORS
    |api/*
    */

    'paths'                    => ['*','/login','/logout','/reset/password','/update/password','/sanctum/csrf-cookie'],
    'allowed_methods'          => ['*'],
    'allowed_origins'          => ['http://localhost:3000','http://localhost:3001','https://ventas.balquimia.com', 'https://computron.balquimia.com', 'https://api.balquimia.com','https://pagos.balquimia.com' ],
    'allowed_origins_patterns' => [],
    'allowed_headers'          => ['*'],
    'exposed_headers'          => false,
    'max_age'                  => false,
    'supports_credentials'     => true,

];
