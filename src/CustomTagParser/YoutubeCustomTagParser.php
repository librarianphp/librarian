<?php


namespace Librarian\CustomTagParser;


use Librarian\CustomTagParserInterface;

class YoutubeCustomTagParser implements CustomTagParserInterface
{
    /**
     * @param string $tag_value
     * @return string
     */
    public function parse($tag_value)
    {
        return $this->getEmbed("https://www.youtube.com/embed/" . $tag_value);
    }

    /**
     * @param string $video_url
     * @return string
     */
    public function getEmbed($video_url)
    {
        return sprintf('<iframe width="560" height="315" src="%s" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>', $video_url);
    }
}