<?php

require __DIR__ . '/../vendor/autoload.php';

use Minicli\App;
use Librarian\Provider\TwigServiceProvider;
use Librarian\Provider\RouterServiceProvider;
use Librarian\Exception\RouteNotFoundException;
use Librarian\Provider\ContentServiceProvider;
use Librarian\Provider\LibrarianServiceProvider;
use Librarian\Response;

$app = new App(load_config());

// register services
$services = include __DIR__ . '/../services.php';
foreach ($services as $serviceName => $service) {
    $app->addService($serviceName, $service);
}

$app->addService('router', new RouterServiceProvider());
$app->librarian->boot();

try {
    /** @var RouterServiceProvider $router */
    $route = $app->router->getCallableRoute();
    $app->runCommand(['minicli', 'web', $route]);
} catch (RouteNotFoundException $e) {
    Response::redirect('/notfound');
}
