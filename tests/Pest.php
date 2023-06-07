<?php

declare(strict_types=1);

/*
|--------------------------------------------------------------------------
| Test Case
|--------------------------------------------------------------------------
|
| The closure you provide to your test functions is always bound to a specific PHPUnit test
| case class. By default, that class is "PHPUnit\Framework\TestCase". Of course, you may
| need to change it using the "uses()" function to bind a different classes or traits.
|
*/

// uses(Tests\TestCase::class)->in('Feature');

/*
|--------------------------------------------------------------------------
| Expectations
|--------------------------------------------------------------------------
|
| When you're writing tests, you often need to check that values meet certain conditions. The
| "expect()" function gives you access to a set of "expectations" methods that you can use
| to assert different things. Of course, you may extend the Expectation API at any time.
|
*/

expect()->extend('toBeOne', fn () => $this->toBe(1));

/*
|--------------------------------------------------------------------------
| Functions
|--------------------------------------------------------------------------
|
| While Pest is very powerful out-of-the-box, you may have some testing code specific to your
| project that you don't want to repeat in every file. Here you can also expose helpers as
| global functions to help you to reduce the number of lines of code in your test files.
|
*/

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
    $config = load_config();

    return $config[$key] ?? null;
}

function getCommandCall(?array $parameters = null): CommandCall
{
    return new CommandCall(array_merge(['minicli'], $parameters));
}
