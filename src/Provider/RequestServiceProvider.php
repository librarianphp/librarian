<?php


namespace Miniweb\Provider;


use Minicli\App;
use Minicli\ControllerInterface;
use Minicli\ServiceInterface;
use Miniweb\Exception\RouteNotFoundException;

class RequestServiceProvider implements ServiceInterface
{
    /** @var App */
    protected $app;

    /** @var array */
    protected $params;

    /** @var string */
    protected $requestURI;


    /**
     * @param App $app
     */
    public function load(App $app)
    {
        $this->app = $app;
        $this->params = $_REQUEST;
        $this->requestURI = $_SERVER['REQUEST_URI'];
    }

    public function getPath()
    {
        $info = parse_url($this->requestURI);

        return str_replace('/', '', $info['path']);
    }

    public function getRoute()
    {
        return $this->getPath() ?: 'index';
    }

    public function getCallableRoute()
    {
        $controller = $this->app->command_registry->getCallableController('web', $this->getRoute());

        if ($controller === null) {
            throw new RouteNotFoundException('Route not Found.');
        }

        return $this->getRoute();
    }
}