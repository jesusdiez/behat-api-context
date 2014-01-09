<?php

namespace Akamon\Behat\ApiContext\Domain\Tests\Model;

use Akamon\Behat\ApiContext\Domain\Model\Response;

class ResponseTest extends \PHPUnit_Framework_TestCase
{
    public function testResponse()
    {
        $statusCode = '204';
        $content = 'foo';
        $headers = array('foo' => 'bar');

        $response = new Response($statusCode, $content, $headers);

        $this->assertSame($statusCode, $response->getStatusCode());
        $this->assertSame($content, $response->getContent());
        $this->assertSame($headers, $response->getHeaders());
    }
}
