<?php

namespace App\Command\Web;

use Librarian\Provider\TwigServiceProvider;
use Librarian\WebController;
use Librarian\Response;
use Librarian\Provider\ContentServiceProvider;

class IndexController extends WebController
{
    public function handle()
    {
        /** @var TwigServiceProvider $twig */
        $twig = $this->getApp()->twig;

        $page = 1;
        $limit = $this->getApp()->config->posts_per_page ?: 10;
        $params = $this->getRequest()->getParams();

        if (key_exists('page', $params)) {
            $page = $params['page'];
        }

        $start = ($page * $limit) - $limit;

        /** @var ContentServiceProvider $content_provider */
        $content_provider = $this->getApp()->content;
        $content_list = $content_provider->fetchAll($start, $this->getApp()->config->posts_per_page);

        $output = $twig->render('content/listing.html.twig', [
            'content_list'  => $content_list,
            'total_pages' => $content_provider->fetchTotalPages($limit),
            'current_page' => $page
        ]);

        $response = new Response($output);

        $response->output();
    }
}