<?php

namespace Miniweb;

use Minicli\App;
use Minicli\Command\CommandCall;
use Minicli\ControllerInterface;
use Miniweb\Provider\RequestServiceProvider;

abstract class WebController implements ControllerInterface
{
    /** @var  App */
    protected $app;

    /** @var  CommandCall */
    protected $input;

    /**
     * Command Logic.
     * @return void
     */
    abstract public function handle();

    /**
     * Called before `run`.
     * @param App $app
     */
    public function boot(App $app)
    {
        $this->app = $app;
    }

    /**
     * @param CommandCall $input
     */
    public function run(CommandCall $input)
    {
        $this->input = $input;
        $this->handle();
    }

    /**
     * Called when `run` is successfully finished.
     * @return void
     */
    public function teardown()
    {
        //
    }

    /**
     * @return App
     */
    public function getApp()
    {
        return $this->app;
    }

    /**
     * @return Request
     */
    public function getRequest()
    {
        /** @var RequestServiceProvider $request */
        $request_provider = $this->getApp()->request;

        return $request_provider->getRequest();
    }
}