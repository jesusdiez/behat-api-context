<?php

namespace Akamon\Behat\ApiContext\Infrastructure\Tests\RequestConverter;

use Akamon\Behat\ApiContext\Domain\Model\Request;
use Akamon\Behat\ApiContext\Infrastructure\RequestConverter\SymfonyHttpFoundationRequestConverter;
use Symfony\Component\HttpFoundation\Request as SymfonyRequest;

class SymfonyHttpFoundationRequestConverterTest extends \PHPUnit_Framework_TestCase
{
    public function testConvert()
    {
        $uri = '/foo';
        $method = 'POST';
        $parameters = array('a' => 1, 'b' => 2);
        $headers = array('c' => 3, 'd' => 4);
        $content = 'ups';

        $request = new Request($method, $uri);
        $request->setParameters($parameters);
        $request->setHeaders($headers);
        $request->setContent($content);

        $cookies = array();
        $files = array();
        $server = array('HTTP_c' => 3, 'HTTP_d' => 4);
        $symfonyRequest = SymfonyRequest::create($uri, $method, $parameters, $cookies, $files, $server, $content);

        $converter = new SymfonyHttpFoundationRequestConverter();
        $this->assertEquals($symfonyRequest, $converter->convert($request));
    }
}
