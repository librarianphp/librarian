<?php

namespace Librarian\Provider;

use Librarian\Content;
use Librarian\ContentCollection;
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
     * @return Content
     * @throws \Exception
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

        return $content;
    }

    /**
     * @param int $start
     * @param int $limit
     * @return ContentCollection
     */
    public function fetchAll($start = 0, $limit = 20)
    {
        $list = [];
        foreach (glob($this->data_path . '/*', GLOB_ONLYDIR) as $route) {
            $content_type = basename($route);

            foreach (glob($route . '/*.md') as $filename) {

                $content = new Content($filename);

                try {
                    $content->setRoute($content_type);
                    $list[] = $content;
                } catch (ContentNotFoundException $e) {
                    continue;
                } catch (\Exception $e) {
                }
            }
        }

        $ordered_content = array_reverse($list);
        return new ContentCollection(array_slice($ordered_content, $start, $limit));
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

        /** @var ContentCollection $content */
        $content = $this->fetchAll(0, 1000);
        $tags = [];

        /** @var Content $article */
        foreach ($content as $article) {
            if ($article->tag_list) {
                $article_tags = explode(',', $article->tag_list);

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
     * @return ContentCollection
     * @throws ContentNotFoundException
     */
    public function fetchFrom($route)
    {
        $feed = [];

        foreach (glob($this->data_path . '/' . $route . '/*.md') as $filename) {
            $content = new Content($filename);
            $content->load();
            $content->setRoute($route);
            $feed[] = $content;
        }

        return new ContentCollection(array_reverse($feed));
    }
}