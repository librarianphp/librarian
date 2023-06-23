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
use Minicli\App;
use Minicli\Command\CommandCall;

function getApp(): App
{
    $app = new App([], 'Type "./librarian help" for help with available commands.', __DIR__ . '/../');

    // Override config for ContentService and reload it
    $app->config->templates_path = __DIR__ . '/resources';
    $app->config->data_path = __DIR__ . '/resources';
    $app->config->cache_path = __DIR__ . '/resources';

    $app->addService('content', new ContentServiceProvider());

    return $app;
}

function getCommandCall(?array $parameters = null): CommandCall
{
    return new CommandCall(array_merge(['minicli'], $parameters));
}
