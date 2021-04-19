<?php

namespace App\Command\Web;

use Librarian\Provider\TwigServiceProvider;
use Librarian\Response;
use Librarian\Provider\ContentServiceProvider;
use Librarian\WebController;

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
            try {
                $content_list = $content_provider->fetchFrom($request->getRoute());
            } catch (\Exception $e) {
                Response::redirect('/notfound');
            }

            $output = $twig->render('content/listing.html.twig', ['content_list' => $content_list]);
        } else {

            try {
                $content = $content_provider->fetch($request->getRoute() . '/' . $request->getSlug());
            } catch (\Exception $e) {
                Response::redirect('/notfound');
            }

            if ($content === null) {
                Response::redirect('/notfound');
            }

            $output = $twig->render('content/single.html.twig', ['content' => $content]);
        }

        $response = new Response($output);
        $response->output();
    }
}