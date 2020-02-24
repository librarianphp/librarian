<?php


namespace Librarian\Provider;

use Librarian\Content;
use Librarian\Exception\ApiException;
use Librarian\Exception\MissingConfigException;
use Minicli\App;
use Minicli\ServiceInterface;
use Minicli\Curly\Client;

class DevtoServiceProvider implements ServiceInterface
{
    /** @var string Dev.to username to pull articles from */
    protected $username;

    /** @var string local path to save static markdown files from dev.to content */
    protected $data_path;

    static $API_ARTICLES_ENDPOINT = 'https://dev.to/api/articles';

    /**
     * @param App $app
     * @throws MissingConfigException
     */
    public function load(App $app)
    {
        if (!$app->config->has('devto_username')) {
            throw new MissingConfigException('devto_username config not found.');
        }

        if (!$app->config->has('devto_datadir')) {
            throw new MissingConfigException('devto_datadir config not found.');
        }

        if (!$app->config->has('data_path')) {
            throw new MissingConfigException('data_path config not found.');
        }

        $this->username = $app->config->devto_username;
        $this->data_path = $app->config->data_path . '/' . $app->config->devto_datadir;
    }

    /**
     * Fetches the latest dev.to articles and save them to local data dir as .md files.
     * Warning: Existing content will be overwritten.
     * @throws ApiException
     */
    public function fetchAll()
    {
        $crawler = new Client();

        $articles_response = $crawler->get(self::$API_ARTICLES_ENDPOINT . '?username=' . $this->username);

        if ($articles_response['code'] !== 200) {
            throw new ApiException('Error while contacting the dev.to API.');
        }

        $articles = json_decode($articles_response['body'], true);

        foreach ($articles as $article) {
            $full_article_response = $crawler->get(self::$API_ARTICLES_ENDPOINT . '/' . $article['id']);

            if ($full_article_response['code'] !== 200) {
                throw new ApiException('Error while contacting the dev.to API.');
            }

            $full_article = json_decode($full_article_response['body'], true);

            try {
                $published = new \DateTime($full_article['published_timestamp']);
            } catch (\Exception $e) {
                $published = new \DateTime();
            }

            $date = $published->format('Ymd');

            $content = new Content($this->data_path . '/' . $date . '_' . $full_article['slug'] . '.md');
            $content->save($full_article['body_markdown']);
        }
    }
}