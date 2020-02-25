<?php

namespace Librarian\Provider;

use Librarian\Content;
use Minicli\App;
use Minicli\ServiceInterface;
use Minicli\Miniweb\Provider\TwigServiceProvider;
use Twig\TwigFunction;

class LibrarianServiceProvider implements ServiceInterface
{
    public function boot()
    {
        //dummy method to force eager load
    }

    /**
     * @param App $app
     * @throws \Exception
     */
    public function load(App $app)
    {
        /** @var TwigServiceProvider $twig_service */
        $twig_service = $app->twig;

        if ($twig_service === null) {
            throw new \Exception("Unable to find Twig Service Provider. Make sure it is registered first.");
        }

        $twig = $twig_service->getTwig();

        $twig->addFunction(new TwigFunction('site_title', function () use ($app) {
            return $app->config->site_name ?: null;
        }));

        $twig->addFunction(new TwigFunction('site_description', function () use ($app) {
            return $app->config->site_description ?: null;
        }));

        $twig->addFunction(new TwigFunction('site_root', function () use ($app) {
            return $app->config->site_root ?: null;
        }));

        $twig->addFunction(new TwigFunction('social_links', function () use ($app) {
            return $app->config->social_links ?: null;
        }));

        $twig->addFunction(new TwigFunction('site_about', function () use ($app) {
            if ($app->config->has('site_about')) {
                $route_about = $app->config->data_path . '/' . $app->config->site_about . '.md';

                $content = new Content($route_about);
                $content->load();

                return $content->description;
            }

            return $app->config->site_description ?: null;
        }));

        $twig->addFunction(new TwigFunction('tag_list', function () use ($app) {
            /** @var ContentServiceProvider $content */
            $content = $app->content;
            return $content->fetchTagList();
        }));
    }
}