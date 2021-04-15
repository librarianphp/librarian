<?php

namespace App\Command\Web;

use Librarian\Provider\TwigServiceProvider;
use Librarian\Response;
use Librarian\Provider\ContentServiceProvider;
use Librarian\WebController;

class TagController extends WebController
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
            Response::redirect('/notfound');
        }

        $content_list = $content_provider->fetchFromTag($request->getSlug());

        $output = $twig->render('content/listing.html.twig', [
            'content_list' => $content_list,
            'tag_name' => $request->getSlug(),
        ]);

        $response = new Response($output);
        $response->output();
    }
}