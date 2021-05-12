<?php

namespace App\Command\Help;

use League\CommonMark\Block\Element\Paragraph;
use Minicli\App;
use Minicli\Command\CommandController;
use Minicli\Command\CommandRegistry;

class DefaultController extends CommandController
{
    /** @var  array */
    protected $command_map = [];

    public function boot(App $app)
    {
        parent::boot($app);
        $this->command_map = $app->command_registry->getCommandMap();
    }
    
    public function handle()
    {
        $this->getPrinter()->info($this->app->getSignature());

        $print_table[] = [ 'Namespace', 'Command' ];

        foreach ($this->command_map as $command => $sub) {
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