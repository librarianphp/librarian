<?php


namespace Miniweb\Provider;


use Minicli\App;
use Minicli\ControllerInterface;
use Minicli\ServiceInterface;
use Miniweb\Exception\RouteNotFoundException;
use Miniweb\Request;

class RequestServiceProvider implements ServiceInterface
{
    /** @var App */
    protected $app;

    /** @var Request */
    protected $request;

    /**
     * @param App $app
     */
    public function load(App $app)
    {
        $this->app = $app;
        $this->request = new Request($_REQUEST, $_SERVER['REQUEST_URI']);
    }

    public function getRoute()
    {
        return $this->request->getRoute() ?: 'index';
    }

    public function getCallableRoute()
    {
        $route = $this->getRoute();

        $controller = $this->app->command_registry->getCallableController('web', $route);

        if ($controller === null) {
            //no dedicated controller found. is it a static content from the data dir? if not, throw exception

            if (!$this->app->config->has('data_path')) {
                throw new \Exception("Missing Static Data Path.");
            }

            $data_path = $this->app->config->data_path;

            if (is_dir($data_path . '/' . $route)) {
                return 'static';
            }

            throw new RouteNotFoundException('Route not Found.');
        }

        return $this->getRoute();
    }

    public function getRequest()
    {
        return $this->request;
    }
}