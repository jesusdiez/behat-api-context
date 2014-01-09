<?php

namespace Akamon\Behat\ApiContext\Domain\Tests\Model;

use Akamon\Behat\ApiContext\Domain\Model\Request;

class RequestTest extends \PHPUnit_Framework_TestCase
{
    public function testConstruction()
    {
        $method = 'POST';
        $uri = '/';

        $request = new Request($method, $uri);

        $this->assertSame($method, $request->getMethod());
        $this->assertSame($uri, $request->getUri());
        $this->assertSame(array(), $request->getHeaders());
        $this->assertSame(array(), $request->getParameters());
        $this->assertNull($request->getContent());
    }

    public function testSetters()
    {
        $request = new Request('GET', '/bar');

        $headers = range(1, 20);
        $request->setHeaders($headers);
        $this->assertSame($headers, $request->getHeaders());

        $parameters = range(1, 20);
        $request->setParameters($parameters);
        $this->assertSame($parameters, $request->getParameters());

        $content = 'foobar';
        $request->setContent($content);
        $this->assertSame($content, $request->getContent());
    }
}
