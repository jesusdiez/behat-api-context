<?php

namespace Akamon\Behat\ApiContext\Domain\Model;

class Request
{
    private $method;
    private $uri;
    private $headers = array();
    private $parameters = array();
    private $content;

    public function __construct($method, $uri)
    {
        $this->method = $method;
        $this->uri = $uri;
    }

    public function getContent()
    {
        return $this->content;
    }

    public function getHeaders()
    {
        return $this->headers;
    }

    public function getMethod()
    {
        return $this->method;
    }

    public function getParameters()
    {
        return $this->parameters;
    }

    public function getUri()
    {
        return $this->uri;
    }

    public function setHeaders($headers)
    {
        $this->headers = $headers;
    }

    public function setParameters($parameters)
    {
        $this->parameters = $parameters;
    }

    public function setContent($content)
    {
        $this->content = $content;
    }
}
