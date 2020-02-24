<?php

namespace Librarian\Provider;

use Librarian\Content;
use Librarian\Exception\ContentNotFoundException;
use Minicli\App;
use Minicli\ServiceInterface;
use Minicli\Util\FileCache;
use Minicli\Miniweb\Request;

class ContentServiceProvider implements ServiceInterface
{
    /** @var string */
    protected $data_path;

    /** @var string */
    protected $cache_path;

    /**
     * @param App $app
     * @throws \Exception
     */
    public function load(App $app)
    {
        if (!$app->config->has('data_path')) {
            throw new \Exception("Missing Data Path.");
        }

        if (!$app->config->has('cache_path')) {
            throw new \Exception("Missing Cache Path.");
        }

        $this->data_path = $app->config->data_path;
        $this->cache_path = $app->config->cache_path;
    }

    /**
     * @param Request $request
     * @return array|null
     */
    public function fetch(Request $request)
    {
        $filename = $this->data_path . '/' . $request->getRoute() . '/' . $request->getSlug() . '.md';

        $content = new Content($filename);

        try {
            $content->load();
            $content->setRoute($request->getRoute());

        } catch (ContentNotFoundException $e) {
            return null;
        }

        return $content->toArray();
    }

    /**
     * @return array
     */
    public function fetchAll()
    {
        $feed = [];

        foreach (glob($this->data_path . '/*', GLOB_ONLYDIR) as $route) {
            $content_type = basename($route);

            $cache = new FileCache($this->cache_path);
            /*$cached_content = $cache->getCachedUnlessExpired($content_type);

            if ($cached_content !== null) {
                return json_decode($cached_content, true);
            }*/

            $feed = [];

            foreach (glob($route . '/*.md') as $filename) {

                $content = new Content($filename);

                try {
                    $content->load();
                    $content->setRoute($content_type);
                    $feed[] = $content->toArray();
                } catch (ContentNotFoundException $e) {
                    continue;
                }
            }

            //write to cache file
            $cache->save(json_encode($feed), $content_type);
        }

        //newest first
        return array_reverse($feed);
    }

    /**
     * @return array|mixed
     */
    public function fetchTagList()
    {
        $cache = new FileCache($this->cache_path);
        $cache_id = "full_tag_list";

        $cached_content = $cache->getCachedUnlessExpired($cache_id);

        if ($cached_content !== null) {
            return json_decode($cached_content, true);
        }

        $content = $this->fetchAll();
        $tags = [];

        foreach ($content as $article) {
            if ($article['tag_list']) {
                $article_tags = explode(',', $article['tag_list']);

                foreach ($article_tags as $article_tag) {
                    $tag_name = trim(str_replace('#', '', $article_tag));

                    $tags[$tag_name][] = $article;
                }
            }
        }

        //write to cache file
        $cache->save(json_encode($tags), $cache_id);

        return $tags;
    }

    /**
     * @param $tag
     * @return mixed|null
     */
    public function fetchFromTag($tag)
    {
        $full_tag_list = $this->fetchTagList();

        if (key_exists($tag, $full_tag_list)) {
            return $full_tag_list[$tag];
        }

        return null;
    }

    /**
     * @param $route
     * @return array
     * @throws ContentNotFoundException
     */
    public function fetchFrom($route)
    {
        $feed = [];

        foreach (glob($this->data_path . '/' . $route . '/*.md') as $filename) {
            $content = new Content($filename);
            $content->load();
            $content->setRoute($route);
            $feed[] = $content->toArray();
        }

        return $feed;
    }
}