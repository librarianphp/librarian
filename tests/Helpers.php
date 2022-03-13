<?php

use Librarian\Provider\ContentServiceProvider;
use Librarian\Provider\LibrarianServiceProvider;
use Librarian\Provider\RouterServiceProvider;
use Librarian\Provider\TwigServiceProvider;
use Minicli\App;
use Minicli\Command\CommandCall;
use Minicli\Curly\Client;

function getCommandsPath(): string
{
    return __DIR__ . '/../app/Command';
}

function getApp(): App
{
    return new App(include __DIR__ . '/../config.php');
}

function getWebApp(): App
{
    $app = new App(include __DIR__ . '/../config.php');
    $app->addService('content', new ContentServiceProvider());
    $app->addService('twig', new TwigServiceProvider());
    $app->addService('librarian', new LibrarianServiceProvider());
    $app->addService('router', new RouterServiceProvider());

    return $app;
}

function getConfigValue(string $key): mixed
{
    $config = include __DIR__ . '/../config.php';

    return $config[$key] ?: null;
}

function getCommandCall(array $parameters = null): CommandCall
{
    return new CommandCall(array_merge(['minicli'], $parameters));
}

function getResponseCode(string $endpoint): int
{
    $base_url = getConfigValue('app_testing_url');
    $client = new Client();
    $response = $client->get($base_url . $endpoint, ['User-agent: Curly'], true);

    return $response['code'];
}

function getResponseBody(string $endpoint): string
{
    $base_url = getConfigValue('app_testing_url');
    $client = new Client();
    $response = $client->get($base_url . $endpoint, ['User-agent: Curly'], true);

    return $response['body'];
}