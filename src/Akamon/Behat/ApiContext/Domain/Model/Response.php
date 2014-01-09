<?php

namespace Akamon\Behat\ApiContext\Domain\Model;

class Response
{
    private $statusCode;
    private $content;
    private $headers = array();

    public function __construct($statusCode, $content, array $headers)
    {
        $this->content = $content;
        $this->headers = $headers;
        $this->statusCode = $statusCode;
    }

    public function getContent()
    {
        return $this->content;
    }

    public function getHeaders()
    {
        return $this->headers;
    }

    public function getStatusCode()
    {
        return $this->statusCode;
    }
}
