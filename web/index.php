<?php

require __DIR__ . '/../vendor/autoload.php';

use Minicli\App;
use Miniweb\Provider\TwigServiceProvider;
use Miniweb\Provider\RequestServiceProvider;
use Miniweb\Exception\RouteNotFoundException;

$app = new App(require __DIR__ . '/../config.php');

$app->addService('twig', new TwigServiceProvider());
$app->addService('request', new RequestServiceProvider());

try {

    /** @var RequestServiceProvider $request */
    $route = $app->request->getCallableRoute();

    $app->runCommand(['minicli', 'web', $route]);

} catch (RouteNotFoundException $e) {
    // 404
    echo "ERROR: Route not found.";
}