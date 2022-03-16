<?php

require __DIR__ . '/../vendor/autoload.php';

use Minicli\App;
use Librarian\Provider\TwigServiceProvider;
use Librarian\Provider\RouterServiceProvider;
use Librarian\Exception\RouteNotFoundException;
use Librarian\Provider\ContentServiceProvider;
use Librarian\Provider\DevtoServiceProvider;
use Librarian\Provider\LibrarianServiceProvider;
use Librarian\Response;

$app = new App(load_config());

$app->addService('twig', new TwigServiceProvider());
$app->addService('router', new RouterServiceProvider());
$app->addService('content', new ContentServiceProvider());
$app->addService('librarian', new LibrarianServiceProvider());
$app->addService('devto', new DevtoServiceProvider());

$app->librarian->boot();

try {
    /** @var RouterServiceProvider $router */
    $route = $app->router->getCallableRoute();
    $app->runCommand(['minicli', 'web', $route]);
} catch (RouteNotFoundException $e) {
    Response::redirect('/notfound');
}