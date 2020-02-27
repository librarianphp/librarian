<?php


namespace App\Command\Cache;

use Librarian\Provider\ContentServiceProvider;
use Minicli\Command\CommandController;
use Minicli\Config;

class RefreshController extends CommandController
{
    public function handle()
    {
        /** @var ContentServiceProvider $content_provider */
        $content_provider = $this->getApp()->content;

        /** @var Config $config */
        $config = $this->getApp()->config;
        if (!$config->has('cache_path')) {
            $this->getPrinter()->error("Missing cache_path configuration.");
        }

        $cache_path = $config->cache_path;

        $this->getPrinter()->info("Clearing cache...");
        foreach (glob($cache_path . "/*.json") as $filename) {
            unlink($filename);
        }

        $content_provider->fetchTagList();

        $this->getPrinter()->success("Cache updated.");
    }

}