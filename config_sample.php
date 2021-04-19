<?php

/**
 * Librarian Main Configuration
 */

return [
    #########################################################################################
    # Librarian site Info
    # You should update this accordingly, and/or set up ENV vars with your preferred values.
    #########################################################################################
    'site_name' => getenv('SITE_NAME') ?: 'Librarian',
    'site_author' => getenv('SITE_AUTHOR') ?: 'librarian@example.com',
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

    ##########################################################################################
    # Dev.to Settings
    # Set Up your dev.to username here or via ENV var.
    # This is required if you want to import your posts from the dev.to platform.
    ##########################################################################################
    'devto_username' => getenv('DEVTO_USER'),
    'devto_datadir' =>  '_to',

    ###################################################
    # Other Settings
    # You shouldn't need to change the next settings,
    # but you are free to do so at your own risk.
    ###################################################
    'app_path' => __DIR__ . '/app/Command',
    'theme' => 'unicorn',
    'templates_path' => __DIR__ . '/app/Resources/themes/default',
    'data_path' => __DIR__ . '/app/Resources/data',
    'cache_path' => __DIR__ . '/var/cache',
    'stencil_dir' => __DIR__ . '/app/Resources/stencil',
    'stencil_locations' => [
        'post' => __DIR__ . '/app/Resources/data/_p'
    ]
];