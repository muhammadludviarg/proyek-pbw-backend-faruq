<?php

return [
    'paths' => ['api/*', 'sanctum/csrf-cookie'], // Pastikan sanctum/csrf-cookie ada di sini
    'allowed_methods' => ['*'],
    'allowed_origins' => [
        'https://proyek-pbw-frontend-faruq.vercel.app', // GANTI DENGAN URL VERCEL ANDA YANG SEBENARNYA
    ],
    'allowed_origins_patterns' => [],
    'allowed_headers' => ['*'],
    'exposed_headers' => [],
    'max_age' => 0,
    'supports_credentials' => true, // PASTIKAN TRUE
];
