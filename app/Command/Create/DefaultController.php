<?php

namespace App\Command\Create;

use Minicli\App;
use Minicli\Command\CommandController;

class DefaultController extends CommandController
{
    public function handle(): void
    {
        $this->getPrinter()->info("./librarian create [subcommand]", true);
        $this->getPrinter()->info("Run \"./librarian create content\" to create a content file based on a template.");
    }
}
