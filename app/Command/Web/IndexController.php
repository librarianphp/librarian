<?php

namespace App\Command\Web;

use Librarian\Provider\TwigServiceProvider;
use Librarian\Request;
use Librarian\WebController;
use Librarian\Response;
use Librarian\Provider\ContentServiceProvider;

class IndexController extends WebController
{
    public function handle()
    {
        /** @var TwigServiceProvider $twig */
        $twig = $this->getApp()->twig;
        /** @var ContentServiceProvider $content_provider */
        $content_provider = $this->getApp()->content;
        $request = $this->getRequest();

        if ($this->getApp()->config->site_index !== null) {
            $content = $content_provider->fetch($this->getApp()->config->site_index);
            if ($content) {
                $response = new Response($twig->render('content/single.html.twig', [
                    'content' => $content
                ]));

                $response->output();
                return 0;
            }
        }

        $page = 1;
        $limit = $this->getApp()->config->posts_per_page ?: 10;
        $params = $request->getParams();

        if (key_exists('page', $params)) {
            $page = $params['page'];
        }

        $start = ($page * $limit) - $limit;

        $content_list = $content_provider->fetchAll($start, $this->getApp()->config->posts_per_page);

        $output = $twig->render('content/listing.html.twig', [
            'content_list'  => $content_list,
            'total_pages' => $content_provider->fetchTotalPages($limit),
            'current_page' => $page
        ]);

        $response = new Response($output);

        $response->output();
        return 0;
    }
}
