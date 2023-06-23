<?php

declare(strict_types=1);

require __DIR__ . '/../vendor/autoload.php';

use Librarian\Exception\RouteNotFoundException;
use Librarian\Provider\RouterServiceProvider;
use Librarian\Response;
use Minicli\App;

$app = new App();
$app->addService('router', new RouterServiceProvider());
$app->librarian->boot();

try {
    /** @var RouterServiceProvider $router */
    $route = $app->router->getCallableRoute();
    $app->runCommand(['minicli', 'web', $route]);
} catch (RouteNotFoundException $e) {
    Response::redirect('/notfound');
}
