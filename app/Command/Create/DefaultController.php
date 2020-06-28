<?php


namespace App\Command\Create;

use Minicli\Command\CommandController;

class DefaultController extends CommandController
{
    public function handle()
    {
        $this->info("Create content and commands using pre-defined templates.");
    }
}