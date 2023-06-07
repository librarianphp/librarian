<?php

declare(strict_types=1);

use Librarian\Builder\StaticBuilder;
use Librarian\Provider\ContentServiceProvider;
use Librarian\Provider\LibrarianServiceProvider;
use Librarian\Provider\TwigServiceProvider;

return [
    /***********************************************
     * Services to Register within the Application
     **********************************************/
    'content' => new ContentServiceProvider(),
    'twig' => new TwigServiceProvider(),
    'librarian' => new LibrarianServiceProvider(),
    'builder' => new StaticBuilder(),
];
