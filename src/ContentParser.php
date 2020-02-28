<?php


namespace Librarian;

use Librarian\CustomTagParser\TwitterCustomTagParser;
use Librarian\CustomTagParser\YoutubeCustomTagParser;

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

    /** @var array */
    protected $custom_tag_parsers;
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

        $this->addCustomTagParser('twitter', new TwitterCustomTagParser());
        $this->addCustomTagParser('youtube', new YoutubeCustomTagParser());
    }

    public function addCustomTagParser($name, CustomTagParserInterface $tag_parser)
    {
        $this->custom_tag_parsers[$name] = $tag_parser;
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
     * @param string $text
     * @return string
     */
    public function parseSpecial($text)
    {
        return preg_replace_callback_array([
            '/^\{%\s(.*)\s(.*)\s%}/m' => function ($match) {

                if (array_key_exists($match[1], $this->custom_tag_parsers)) {
                    $parser = $this->custom_tag_parsers[$match[1]];
                    if ($parser instanceof CustomTagParserInterface) {
                        return $parser->parse($match[2]);
                    }
                }

                return $match[2];
            },
        ], $text);
    }
}