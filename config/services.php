<?php

declare(strict_types=1);

use Librarian\Builder\StaticBuilder;
use Librarian\Provider\ContentServiceProvider;
use Librarian\Provider\FeedServiceProvider;
use Librarian\Provider\LibrarianServiceProvider;
use Librarian\Provider\TwigServiceProvider;

return [
    /****************************************************************************
     * Application Services
     * --------------------------------------------------------------------------
     *
     * The services to be loaded for your application.
     *****************************************************************************/

    'services' => [
        'content' => ContentServiceProvider::class,

        'twig' => TwigServiceProvider::class,

        'librarian' => LibrarianServiceProvider::class,

        'feed' => FeedServiceProvider::class,

        'builder' => StaticBuilder::class,
    ],
];
