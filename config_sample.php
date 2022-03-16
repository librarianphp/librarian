<?php

return [
    /****************************************************************************************
     * Librarian main config
     * Values set here will overwrite default configuration from the /config dir.
     *****************************************************************************************/
    'site_name' => getenv('SITE_NAME') ?: 'Librarian',
    'site_author' => getenv('SITE_AUTHOR') ?: '@erikaheidi',
    'site_description' => getenv('SITE_DESC') ?: 'Minimalist file-based CMS in PHP',
    'site_url' => getenv('SITE_URL') ?: 'http://localhost:8000',
    'site_root' => getenv('SITE_ROOT') ?: '/',
    'site_about' => getenv('SITE_ABOUT') ?: '_p/about',
    'posts_per_page' => 10,
    'social_links' => [
        'Twitter' => getenv('LINK_TWITTER'),
        'Github'  => getenv('LINK_GITHUB') ?: 'https://github.com/minicli/librarian',
        'YouTube' => getenv('LINK_YOUTUBE'),
        'LinkedIn' => getenv('LINK_LINKEDIN'),
        'Twitch' => getenv('LINK_TWITCH'),
    ],
    'app_debug' => getenv('APP_DEBUG') ?: true,
    'app_testing_url' => getenv('TEST_BASE_URL') ?: 'http://nginx',
    'devto_username' => getenv('DEVTO_USER'),
];
