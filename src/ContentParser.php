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

        //TODO: parse special tags such as {% youtube id %}
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

    public function getFrontMatter()
    {
        return $this->front_matter;
    }

    public function getOriginalContent()
    {
        return $this->original_content;
    }

    public function getMarkdownBody()
    {
        return $this->markdown;
    }

    public function getHtmlBody()
    {
        $parsedown = new \ParsedownExtra();

        try {
            return $parsedown->text($this->markdown);
        } catch (\Exception $e) {
            return null;
        }
    }
}