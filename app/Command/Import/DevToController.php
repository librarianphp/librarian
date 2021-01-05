<?php


namespace App\Command\Import;

use Librarian\Exception\ApiException;
use Librarian\Provider\DevtoServiceProvider;
use Minicli\Command\CommandController;

class DevToController extends CommandController
{
    public function handle()
    {
        /** @var DevtoServiceProvider $devto */
        $devto = $this->getApp()->devto;

        if ($devto === null) {
            $this->getPrinter()->error('ERROR: dev.to service not found. Perhaps you forgot to register it?');
            exit;
        }

        if ($this->getApp()->config->devto_username === null) {
            $this->getPrinter()->error('ERROR: dev.to username not set. You must define a devto_username config variable.');
            exit;
        }

        $this->getPrinter()->info("Starting import... this might take a few minutes.");

        try {
            $devto->fetchAll();
        } catch (ApiException $e) {
            $this->getPrinter()->error($e->getMessage());
        }

        $this->getPrinter()->success("Import Finished.");
    }

}