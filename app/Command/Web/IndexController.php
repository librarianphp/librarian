<?php

namespace App\Command\Web;

use Miniweb\Response;
use Miniweb\WebController;
use Twig\Environment;

class IndexController extends WebController
{
    public function handle()
    {
        /** @var Environment $twig */
        $twig = $this->getApp()->twig;
        $output = $twig->render('index.html.twig', []);

        $response = new Response($output);

        $response->output();
    }
}