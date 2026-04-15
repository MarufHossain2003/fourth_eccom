<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Default SEO Settings
    |--------------------------------------------------------------------------
    */
    
    'site_name' => env('APP_NAME', 'Amar Jinish BD'),
    'site_description' => 'Premium e-commerce platform with quality products',
    'site_url' => env('APP_URL', 'https://amarjinishbd.com'),
    'site_image' => '/images/og-default.png',
    
    /*
    |--------------------------------------------------------------------------
    | Default Meta Tags
    |--------------------------------------------------------------------------
    */
    
    'meta' => [
        'charset' => 'utf-8',
        'viewport' => 'width=device-width, initial-scale=1',
        'language' => env('APP_LOCALE', 'en'),
    ],

    /*
    |--------------------------------------------------------------------------
    | Default Open Graph Tags
    |--------------------------------------------------------------------------
    */
    
    'og' => [
        'type' => 'website',
        'locale' => env('APP_LOCALE', 'en_US'),
    ],

    /*
    |--------------------------------------------------------------------------
    | Twitter Card Settings
    |--------------------------------------------------------------------------
    */
    
    'twitter' => [
        'card' => 'summary_large_image',
        'site' => env('TWITTER_HANDLE', ''),
        'creator' => env('TWITTER_HANDLE', ''),
    ],

    /*
    |--------------------------------------------------------------------------
    | Sitemap Settings
    |--------------------------------------------------------------------------
    */
    
    'sitemap' => [
        'enabled' => true,
        'gzip' => false,
    ],

    /*
    |--------------------------------------------------------------------------
    | Robots.txt Settings
    |--------------------------------------------------------------------------
    */
    
    'robots' => [
        'enabled' => true,
        'disallow' => ['/admin', '/api/', '*/admin/*', '*/api/*'],
        'user_agents_to_disallow' => ['AhrefsBot', 'SemrushBot', 'DotBot'],
    ],

    /*
    |--------------------------------------------------------------------------
    | Schema.org Structured Data
    |--------------------------------------------------------------------------
    */
    
    'schema' => [
        'enabled' => true,
        'organization' => [
            '@type' => 'Organization',
            'name' => env('APP_NAME', 'Amar Jinish BD'),
            'url' => env('APP_URL', 'https://amarjinishbd.com'),
            'logo' => '/images/logo.png',
            'contactPoint' => [
                '@type' => 'ContactPoint',
                'contactType' => 'Customer Service',
            ],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Pagination Settings for Sitemap
    |--------------------------------------------------------------------------
    */
    
    'pagination' => [
        'products_per_page' => 50000,
    ],
];
