<?php

namespace App\Command\Cache;

use Minicli\App;
use Minicli\Command\CommandController;

class DefaultController extends CommandController
{
    public function handle(): void
    {
        $this->getPrinter()->info("./librarian cache [subcommand]", true);
        $this->getPrinter()->info("Run \"./librarian cache clear\" to clear cached tags and pages.");
        $this->getPrinter()->info("Run \"./librarian cache refresh\" to refresh the cache (clear and reload).");
    }
}
