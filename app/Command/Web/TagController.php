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

        $page = 1;
        $limit = $this->getApp()->config->posts_per_page ?: 10;
        $params = $this->getRequest()->getParams();

        if (key_exists('page', $params)) {
            $page = $params['page'];
        }

        $start = ($page * $limit) - $limit;

        try {
            $content_list = $content_provider->fetchFromTag($request->getSlug(), $start, $limit);
        } catch (\Exception $e) {
            Response::redirect('/notfound');
        }

        if (!$content_list) {
            Response::redirect('/notfound');
        }

        $output = $twig->render('content/listing.html.twig', [
            'content_list' => $content_list,
            'tag_name' => $request->getSlug(),
            'total_pages' => $content_provider->fetchTagTotalPages($request->getSlug(), $limit),
            'current_page' => $page
        ]);

        $response = new Response($output);
        $response->output();
    }
}
