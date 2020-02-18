<?php

namespace App\Command\Web;

use Miniweb\Exception\ContentNotFoundException;
use Miniweb\Provider\TwigServiceProvider;
use Miniweb\Response;
use Miniweb\StaticContent;
use Miniweb\WebController;

/**
 * Class StaticController
 * Renders content from the data dirs
 * @package App\Command\Web
 */
class StaticController extends WebController
{
    /**
     * @throws \Exception
     */
    public function handle()
    {
        /** @var TwigServiceProvider $twig */
        $twig = $this->getApp()->twig;

        $request = $this->getRequest();

        if (!$this->getApp()->config->has('data_path')) {
            Response::redirect('/error');
        }

        $data_path = $this->getApp()->config->data_path;

        $content = new StaticContent($data_path, $request->getRoute(), $request->getSlug());

        try {
            $content->load();
        } catch (ContentNotFoundException $e) {
           Response::redirect('/notfound');
        }

        $output = $twig->render('content/static.html.twig', ['content' => $content]);

        $response = new Response($output);
        $response->output();
    }
}