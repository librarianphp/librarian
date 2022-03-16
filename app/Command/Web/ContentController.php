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
    public function handle(): int
    {
        /** @var TwigServiceProvider $twig */
        $twig = $this->getApp()->twig;

        /** @var ContentServiceProvider $content_provider */
        $content_provider = $this->getApp()->content;

        $request = $this->getRequest();

        try {
            $content = $content_provider->fetch($request->getRoute() . '/' . $request->getSlug());

            if ($content === null) {
                $page = 1;
                $limit = $this->getApp()->config->posts_per_page ?: 10;
                $params = $this->getRequest()->getParams();

                if (key_exists('page', $params)) {
                    $page = $params['page'];
                }

                $start = ($page * $limit) - $limit;

                $content_list = $content_provider->fetchFrom($request->getRoute(), $start, $this->getApp()->config->posts_per_page);
                $response = new Response($twig->render('content/listing.html.twig', [
                    'content_list' => $content_list,
                    'total_pages' => $content_provider->fetchTotalPages($limit),
                    'current_page' => $page,
                    'base_url' => $request->getRoute()
                ]));

                $response->output();
                return 0;
            }
        } catch (\Exception $e) {
            Response::redirect('/notfound');
        }

        $output = $twig->render('content/single.html.twig', [
            'content' => $content
        ]);


        $response = new Response($output);
        $response->output();
        return 0;
    }
}
