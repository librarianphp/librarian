<?php

//////////////////////////////////
// minicli/librarian configuration
//////////////////////////////////

return [

    # Command Controllers Path
    'app_path' => __DIR__ . '/app/Command',

    # CLI theme
    'theme' => 'unicorn',

    # Templates Path
    'templates_path' => __DIR__ . '/app/Resources/templates',

    # Static Data Path
    'data_path' => __DIR__ . '/app/Resources/data',

    # Site Info
    'site_name' => 'Librarian',
    'site_description' => 'Tiny CMS for static content',
    'site_root' => '/',

];