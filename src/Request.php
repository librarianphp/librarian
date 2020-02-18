<?php


namespace Miniweb;


class Request
{
    /** @var array */
    protected $params;

    /** @var string */
    protected $request_uri;

    /** @var array */
    protected $request_info;

    /** @var string Full request path */
    protected $path;

    /** @var string Requested route, such as "home", "index", "blog", etc - only 1 level is supported */
    protected $route;

    /** @var string Slug if present (request path minus route) */
    protected $slug;

    public function __construct(array $params, $request_uri)
    {
        $this->params = $params;
        $this->request_uri = $request_uri;

        $this->request_info = parse_url($this->request_uri);
        $this->path = $this->request_info['path'];

        //make sure to get the first part only
        $parts = explode('/', $this->path);

        $this->route = $parts[1];
        $this->slug = str_replace($this->route, '', $this->path);
        $this->slug = str_replace('/', '', $this->slug);
    }

    /**
     * @return array
     */
    public function getParams()
    {
        return $this->params;
    }

    /**
     * @return string
     */
    public function getRequestUri()
    {
        return $this->request_uri;
    }

    /**
     * @return array
     */
    public function getRequestInfo()
    {
        return $this->request_info;
    }

    /**
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * @return string
     */
    public function getRoute()
    {
        return $this->route;
    }

    /**
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }

}