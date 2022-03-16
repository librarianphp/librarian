<?php

namespace App\Command\Help;

use Minicli\App;
use Minicli\Command\CommandController;
use Minicli\Command\CommandRegistry;

class DefaultController extends CommandController
{
    /** @var  array */
    protected array $commandMap = [];

    public function boot(App $app): void
    {
        parent::boot($app);
        $this->commandMap = $app->commandRegistry->getCommandMap();
    }

    public function handle(): void
    {
        $this->getPrinter()->info($this->app->getSignature());

        $print_table[] = [ 'Namespace', 'Command' ];

        foreach ($this->commandMap as $command => $sub) {
            if ($command == 'web') {
                continue;
            }
            $print_table[] = [ $command, ''];
            if (is_array($sub)) {
                foreach ($sub as $subcommand) {
                    if ($subcommand == 'default') {
                        $row = "./librarian $command\n";
                    } else {
                        $row = "./librarian $command $subcommand\n";
                    }

                    $print_table[] = [ '', $row ];
                }
            }
        }

        $this->getPrinter()->printTable($print_table);
    }
}
