<?php

namespace App\Command\Web;

use Minicli\Miniweb\Provider\TwigServiceProvider;
use Minicli\Miniweb\WebController;
use Minicli\Miniweb\Response;
use Librarian\Provider\ContentServiceProvider;

class IndexController extends WebController
{
    public function handle()
    {
        /** @var TwigServiceProvider $twig */
        $twig = $this->getApp()->twig;

        /** @var ContentServiceProvider $static_provider */
        $content_provider = $this->getApp()->content;
        $content_list = $content_provider->fetchAll();

        $output = $twig->render('content/index.html.twig', [
            'content_list'  => $content_list
        ]);

        $response = new Response($output);

        $response->output();
    }
}