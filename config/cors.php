<?php

return [
    'paths' => ['api/*', 'sanctum/csrf-cookie'],

    'allowed_methods' => ['*'],

    // Exact origins
    'allowed_origins' => [
        'http://localhost:3000',
        'https://xpertbid.com',
        'https://xpert-bid-2xep.vercel.app',
		'https://xpertbid-clean.vercel.app/',
        'https://xpertbid-clean-myj82lsdb-rameezs-projects-c3cf64ce.vercel.app/'
    ],

    // Regex for any subdomain of xpertbid.com
    'allowed_origins_patterns' => [
        '/^https:\/\/.*\.xpertbid\.com$/',
      	'/^https:\/\/.*\.vercel\.app/',
    ],

    'allowed_headers' => ['*'],
    'exposed_headers' => [],     // optional, lekin add kar len
    'max_age' => 0,
    'supports_credentials' => true,
];