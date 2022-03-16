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
    return new App(load_config(__DIR__ . '/../config'));
}

function getWebApp(): App
{
    $app = getApp();
    $app->addService('content', new ContentServiceProvider());
    $app->addService('twig', new TwigServiceProvider());
    $app->addService('librarian', new LibrarianServiceProvider());
    $app->addService('router', new RouterServiceProvider());

    return $app;
}

function getConfigValue(string $key): mixed
{
    $config = load_config(__DIR__ . '/../config');

    return $config[$key] ?: null;
}

function getCommandCall(array $parameters = null): CommandCall
{
    return new CommandCall(array_merge(['minicli'], $parameters));
}
