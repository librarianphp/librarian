<?php

namespace App\Command\Web;

use Minicli\Miniweb\Provider\TwigServiceProvider;
use Minicli\Miniweb\Response;
use Librarian\Provider\ContentServiceProvider;
use Minicli\Miniweb\WebController;

/**
 * Class StaticController
 * Renders content from the data dirs
 * @package App\Command\Web
 */
class ContentController extends WebController
{
    /**
     * @throws \Exception
     */
    public function handle()
    {
        /** @var TwigServiceProvider $twig */
        $twig = $this->getApp()->twig;

        /** @var ContentServiceProvider $content_provider */
        $content_provider = $this->getApp()->content;

        $request = $this->getRequest();

        if (!$request->getSlug()) {
            $content_list = $content_provider->fetchFrom($request->getRoute());
            $output = $twig->render('content/listing.html.twig', ['content_list' => $content_list]);
        } else {

            $content = $content_provider->fetch($request);

            if ($content === null) {
                Response::redirect('/notfound');
            }

            $output = $twig->render('content/static.html.twig', ['content' => $content]);
        }

        $response = new Response($output);
        $response->output();
    }
}