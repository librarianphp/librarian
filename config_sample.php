<?php

return [
    /****************************************************************************************
     * Librarian main config
     * Values set here will overwrite default configuration from the /config dir.
     *****************************************************************************************/
    'site_name' => envconfig('SITE_NAME', 'Librarian'),
    'site_author' => envconfig('SITE_AUTHOR', '@erikaheidi'),
    'site_description' => envconfig('SITE_DESC', 'Minimalist file-based CMS in PHP'),
    'site_url' => envconfig('SITE_URL', 'http://localhost:8000'),
    'site_root' => envconfig('SITE_ROOT', '/'),
    'site_about' => envconfig('SITE_ABOUT', 'p/about'),
    'posts_per_page' => 10,
    'social_links' => [
        'Twitter' => getenv('LINK_TWITTER'),
        'Github'  => getenv('LINK_GITHUB') ?: 'https://github.com/minicli/librarian',
        'YouTube' => getenv('LINK_YOUTUBE'),
        'LinkedIn' => getenv('LINK_LINKEDIN'),
        'Twitch' => getenv('LINK_TWITCH'),
    ],
    'app_debug' => getenv('APP_DEBUG') ?: true,
    'app_testing_url' => getenv('TEST_BASE_URL') ?: 'http://localhost:8000',
    'output_path' => envconfig('APP_OUTPUT', __DIR__ . '/public')
];
