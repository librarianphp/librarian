<?php


namespace Librarian;

use Librarian\Exception\ContentNotFoundException;
use ParsedownExtra;
use DateTime;

/**
 * Defines the Content Model
 * @package Miniweb
 */
class Content
{
    /** @var string Path to content static file */
    public $path;

    /** @var string Content Title */
    public $title;

    /** @var string Cover Image if any */
    public $cover_image;

    /** @var string Content Description */
    public $description;

    /** @var string List of tags*/
    public $tag_list;

    /** @var DateTime Published date/time */
    public $published;

    /** @var array Front-matter key-pairs */
    public $front_matter;

    /** @var string Body of content in markdown */
    public $body_markdown;

    /** @var string Body of content in html */
    public $body_html;

    /** @var string Content Slug */
    public $slug;

    /** @var string Route for this Content */
    public $route;


    /**
     * Content constructor.
     * @param null $path
     */
    public function __construct($path = null)
    {
        $this->path = $path;
    }

    /**
     * Sets content type / route
     * @param string $route
     */
    public function setRoute($route)
    {
        $this->route = $route;
    }

    /**
     * @return string
     */
    public function getLink()
    {
        return $this->route . '/' . $this->slug;
    }

    /**
     * @throws ContentNotFoundException
     * @throws \Exception
     */
    public function load()
    {
        if (!file_exists($this->path)) {
            throw new ContentNotFoundException('Content not found.');
        }

        $source = file_get_contents($this->path);

        $parser = new ContentParser($source);
        $this->front_matter = $parser->getFrontMatter();

        $this->title = $this->frontMatterGet('title', $this->getAlternateTitle());
        $this->cover_image = $this->frontMatterGet('cover_image');
        $this->published = $this->getDate();
        $this->description = $this->frontMatterGet('description');
        $this->tag_list = $this->frontMatterGet('tags');
        $this->slug = $this->getSlug();

        $this->body_markdown = $parser->getMarkdownBody();
        $this->body_html = $parser->getHtmlBody();

    }

    /**
     * @param string $content
     */
    public function save($content)
    {
        $file = fopen($this->path, "w+");
        fputs($file, $content);
        fclose($file);
    }

    /**
     * @return string
     * @throws \Exception
     */
    public function getDate()
    {
        $slug = $this->getSlug();
        $parts = explode('_', $slug, 2);

        try {
            $date = new DateTime($parts[0]);
        } catch (\Exception $e) {
            $date = new DateTime();
        }

        return $date->format('F d, Y');
    }

    /**
     * @return mixed|string|string[]
     */
    public function getAlternateTitle()
    {
        $slug = $this->getSlug();

        //remove date
        $parts = explode('_', $slug, 2);

        $title = isset($parts[1]) ? $parts[1] : $slug;

        $title = ucfirst(str_replace('-', ' ', $title));

        return $title;
    }

    /**
     * @return string|string[]
     */
    public function getSlug()
    {
        return str_replace('.md', '', basename($this->path));
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return [
            'title'         => $this->title,
            'cover_image'   => $this->cover_image,
            'description'   => $this->description,
            'published'     => $this->published,
            'tag_list'      => $this->tag_list,
            'body_markdown' => $this->body_markdown,
            'body_html'     => $this->body_html,
            'slug'          => $this->slug,
            'link'          => $this->getLink()
        ];
    }

    /**
     * @param string $key
     * @return bool
     */
    public function frontMatterHas($key)
    {
        return key_exists($key, $this->front_matter);
    }

    /**
     * @param string $key
     * @param string $default_value
     * @return string|null
     */
    public function frontMatterGet($key, $default_value = null)
    {
        if ($this->frontMatterHas($key)) {
            return $this->front_matter[$key] ?: $default_value;
        }

        return $default_value;
    }
}