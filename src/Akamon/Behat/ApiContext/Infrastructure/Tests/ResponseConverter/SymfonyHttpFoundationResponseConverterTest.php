<?php

namespace Akamon\Behat\ApiContext\Infrastructure\Tests\ResponseConverter;

use Akamon\Behat\ApiContext\Domain\Model\Response;
use Akamon\Behat\ApiContext\Infrastructure\ResponseConverter\SymfonyHttpFoundationResponseConverter;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;

class SymfonyHttpFoundationResponseConverterTest extends \PHPUnit_Framework_TestCase
{
    public function testConvert()
    {
        $statusCode = 203;
        $content = 'foo';
        $headers = array('a' => '1', 'b' => '2');

        $symfonyResponse = new SymfonyResponse($content, $statusCode, $headers);
        $response = new Response($statusCode, $content, array_merge($headers, array(
            'cache-control' => $symfonyResponse->headers->get('cache-control'),
            'date' => $symfonyResponse->headers->get('date')
        )));

        $converter = new SymfonyHttpFoundationResponseConverter();

        $this->assertEquals($response, $converter->convert($symfonyResponse));
    }
}
