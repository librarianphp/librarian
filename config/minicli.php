<?php

return [
    /****************************************************************************
     * Minicli Settings
     * You shouldn't need to change the next settings,
     * but you are free to do so at your own risk.
     *****************************************************************************/
    'app_path' => [
        __DIR__ . '/../app/Command',
        '@librarianphp/command-help',
        '@librarianphp/command-create',
        '@librarianphp/command-cache',
        '@librarianphp/command-web',
        '@librarianphp/command-build'
    ],
    'theme' => 'unicorn',
    'templates_path' => __DIR__ . '/../app/Resources/themes/default',
    'data_path' => __DIR__ . '/../content',
    'cache_path' => __DIR__ . '/../var/cache',
    'stencil_dir' => __DIR__ . '/../app/Resources/stencil',
    'stencil_locations' => [
        'post' => __DIR__ . '/../content/post',
        'page' => __DIR__ . '/../content/page'
    ],
    'rss_feed' => php_sapi_name() !== 'cli' ? 'feed' : 'feed.rss',
];
