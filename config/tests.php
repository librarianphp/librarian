<?php

declare(strict_types=1);

return [
    /*****************************************************************************
     * End-to-end tests require you to set here the app url for testing.
     * For Docker Compose setups, this should be where Nginx is running.
     ******************************************************************************/
    'app_testing_url' => 'http://localhost:8000', // Regular LEMP/LAMP/PHP built-in server
    //'app_testing_url' => 'http://nginx', # Docker Compose w/ separate Nginx service

];
