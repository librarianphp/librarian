<?php


namespace Miniweb;


class Response
{
    protected $content;

    public function __construct($content = null)
    {
        $this->content = $content;
    }

    public function output()
    {
        echo $this->content;
    }

    /**
     * @return null
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param null $content
     */
    public function setContent($content)
    {
        $this->content = $content;
    }
}