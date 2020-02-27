<?php


namespace Librarian;

/**
 * Class ContentParser
 * Parses a markdown content with an optional front matter
 * @package Miniweb
 */
class ContentParser
{
    /** @var string  */
    protected $original_content;

    /** @var array */
    protected $front_matter;

    /** @var string */
    protected $markdown;

    /**
     * ContentParser constructor.
     * @param string $content
     */
    public function __construct($content = null)
    {
        $this->original_content = $content;

        if ($content !== null) {
            $this->parse();
        }
    }

    /**
     * Parses the content
     */
    public function parse()
    {
        $parts = preg_split('/[\n]*[-]{3}[\n]/', $this->original_content, 3);

        if (count($parts) > 2) {
            $this->front_matter = $this->extractFrontMatter($parts[1]);
            $this->markdown = $parts[2];
        } else {
            $this->front_matter = [];
            $this->markdown = $this->original_content;
        }
    }

    /**
     * Extracts front-matter from content
     * @param string $front_matter
     * @return array
     */
    protected function extractFrontMatter($front_matter)
    {
        $parts = preg_split('/[\n]*[\n]/', $front_matter);

        $vars = [];
        foreach ($parts as $line) {
            $content = explode(':', $line, 2);
            if (count($content) > 1) {
                $vars[$content[0]] = trim($content[1]);
            }
        }

        return $vars;
    }

    /**
     * @return array
     */
    public function getFrontMatter()
    {
        return $this->front_matter;
    }

    /**
     * @return string|null
     */
    public function getOriginalContent()
    {
        return $this->original_content;
    }

    /**
     * @return string
     */
    public function getMarkdownBody()
    {
        return $this->markdown;
    }

    /**
     * @return string|string[]|null
     * @throws \Exception
     */
    public function getHtmlBody()
    {
        $parsedown = new \ParsedownExtra();

        try {
            $html = $this->parseSpecial($this->markdown);
            return $parsedown->text($html);
        } catch (\Exception $e) {
            return null;
        }
    }

    /**
     * Parses special tags such as {% youtube xyz %}
     * @param $text
     * @return string|string[]|null
     */
    public function parseSpecial($text)
    {
        return preg_replace_callback_array([
            '/^\{%\s(post)\s(.*)\s%}/m' => function ($match) {
                $link = $match[2];
                return "<a href='$link'>$link</a>";
            },
            '/^\{%\s(youtube)\s(.*)\s%}/m' => function ($match) {
                $link = "https://www.youtube.com/embed/" . $match[2];
                return sprintf('<iframe width="560" height="315" src="%s" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>', $link);
            },
            '/^\{%\s(.*)\s(.*)\s%}/m' => function ($match) {
                return "<br>";
            },
        ], $text);
    }
}