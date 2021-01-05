<?php

/**
 * Librarian Main Configuration
 */

return [

    # Command Controllers Path
    'app_path' => __DIR__ . '/app/Command',

    # CLI theme
    'theme' => 'unicorn',

    # Templates Path
    'templates_path' => __DIR__ . '/app/Resources/templates',

    # Static Data Path
    'data_path' => __DIR__ . '/app/Resources/data',

    # Cache Dir
    'cache_path' => __DIR__ . '/var/cache',

    # Librarian site Info
    'site_name' => getenv('SITE_NAME') ?: 'Librarian',
    'site_description' => getenv('SITE_DESC') ?: 'Minimalist file-based CMS in PHP',
    'site_root' => getenv('SITE_ROOT') ?: '/',
    'site_about' => getenv('SITE_ABOUT') ?: '_p/about',
    'social_links' => [
        'Twitter' => getenv('LINK_TWITTER') ?: 'https://twitter.com/erikaheidi',
        'Github'  => getenv('LINK_GITHUB') ?: 'https://github.com/minicli/librarian',
    ],

    # Dev.to Settings
    'devto_username' => getenv('DEVTO_USER'),
    'devto_datadir' =>  '_to',
];