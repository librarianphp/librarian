<?php

namespace App\Command\Example;

use Minicli\Command\CommandController;

class DefaultController extends CommandController
{
    public function handle(): void
    {
        $this->info("This is the example command.");
        $this->info("You can use it as a sandbox or base to build your own custom CLI commands.");
    }
}
