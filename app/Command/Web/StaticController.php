<?php

namespace App\Command\Web;

use Miniweb\Response;
use Miniweb\WebController;
use Twig\Environment;

class StaticController extends WebController
{
    public function handle()
    {
        /** @var Environment $twig */
        $twig = $this->getApp()->twig;

        $request = $this->getRequest();
        $slug = $request->getSlug();

        //search in data dirs

        if (!$this->getApp()->config->has('data_path')) {
            throw new \Exception("Missing Static Data Path.");
        }

        $data_path = $this->getApp()->config->data_path;

        $markdown = '';
        if (is_file($data_path . '/' . $request->getRoute() . '/' . $slug . '.md')) {
            $markdown = file_get_contents($data_path . '/' . $request->getRoute() . '/' . $slug . '.md');
        }

        $output = $twig->render('index.html.twig', ['title' => $this->getRequest()->getSlug(), 'markdown' => $markdown]);

        $response = new Response($output);

        $response->output();
    }
}