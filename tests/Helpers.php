<?php

use Librarian\Provider\ContentServiceProvider;
use Librarian\Provider\LibrarianServiceProvider;
use Librarian\Provider\RouterServiceProvider;
use Librarian\Provider\TwigServiceProvider;
use Minicli\App;
use Minicli\Command\CommandCall;

function getCommandsPath(): string
{
    return __DIR__ . '/../app/Command';
}

function getApp(): App
{
    $config = [
        'app_path' => getCommandsPath()
    ];

    return new App($config);
}

function getWebApp(): App
{
    $config = [
        'debug' => true,
        'app_path' => getCommandsPath(),
        'templates_path' => __DIR__ . '/resources',
        'data_path' => __DIR__ . '/resources',
        'cache_path' => __DIR__ . '/resources'
    ];

    $app = new App($config);
    $app->addService('content', new ContentServiceProvider());
    $app->addService('twig', new TwigServiceProvider());
    $app->addService('librarian', new LibrarianServiceProvider());
    $app->addService('router', new RouterServiceProvider());

    return new App($config);
}

function getCommandCall(array $parameters = null): CommandCall
{
    return new CommandCall(array_merge(['minicli'], $parameters));
}
