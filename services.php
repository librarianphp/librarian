<?php

use Librarian\Provider\ContentServiceProvider;
use Librarian\Provider\LibrarianServiceProvider;
use Librarian\Provider\TwigServiceProvider;
use Librarian\Builder\StaticBuilder;

return [
    /***********************************************
     * Services to Register within the Application
     **********************************************/
    'content' => new ContentServiceProvider(),
    'twig' => new TwigServiceProvider(),
    'librarian' => new LibrarianServiceProvider(),
    'builder' => new StaticBuilder(),
];
