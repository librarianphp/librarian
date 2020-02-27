<?php

namespace App\Command\Cache;

use Minicli\Command\CommandController;
use Minicli\Config;

class ClearController extends CommandController
{
    public function handle()
    {
        /** @var Config $config */
        $config = $this->getApp()->config;
        if (!$config->has('cache_path')) {
            $this->getPrinter()->error("Missing cache_path configuration.");
        }

        $cache_path = $config->cache_path;

        foreach (glob($cache_path . "/*.json") as $filename) {
            unlink($filename);
        }

        $this->getPrinter()->success("Cache cleared.");
    }
}