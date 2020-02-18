<?php


namespace Miniweb;

use Miniweb\Exception\ContentNotFoundException;
use ParsedownExtra;

/**
 * Class StaticContent
 * Manages static content (markdown with support to front matter) from data dirs.
 * @package Miniweb
 */
class StaticContent
{
    protected $data_path;

    protected $route;

    protected $slug;

    protected $source;

    public $front_matter;

    public $markdown;

    public $content;

    public function __construct($data_path, $route, $slug)
    {
        $this->data_path = $data_path;
        $this->route = $route;
        $this->slug = $slug;
    }

    public function getContentFile()
    {
        return $this->data_path . '/' . $this->route . '/' . $this->slug . '.md';
    }

    public function exists()
    {
        return is_file($this->getContentFile());
    }

    public function load()
    {
        if (!$this->exists()) {
            throw new ContentNotFoundException('Content not found.');
        }

        $this->source = file_get_contents($this->getContentFile());

        // front matter
        $parts = preg_split('/[\n]*[-]{3}[\n]/', $this->source, 2);

        if (count($parts) > 1) {
            $this->front_matter = $this->parseFrontMatter($parts[0]);
            $this->markdown = $parts[1];
        } else {
            $this->markdown = $this->source;
        }

        $parsedown = new ParsedownExtra();
        $this->content = $parsedown->text($this->markdown);
    }

    public function parseFrontMatter($front_matter)
    {
        $parts = preg_split('/[\n]*[\n]/', $front_matter);

        $vars = [];
        foreach ($parts as $line) {
            $content = explode(':', $line);
            $vars[$content[0]] = $content[1] ?: null;
        }

        return $vars;
    }

    public function __toString()
    {
        return $this->content;
    }
}