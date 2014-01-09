<?php

namespace Akamon\Behat\ApiContext\Infrastructure\Tests\ClientRequester;

use Akamon\Behat\ApiContext\Infrastructure\ClientRequester\SymfonyHttpKernelClientRequester;
use Akamon\Behat\ApiContext\Domain\Model\Request;
use Akamon\Behat\ApiContext\Domain\Model\Response;
use Symfony\Component\HttpFoundation\Request as SymfonyRequest;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;

class SymfonyHttpKernelClientRequesterTest extends \PHPUnit_Framework_TestCase
{
    public function testRequest()
    {
        $requestConverter = \Mockery::mock('Akamon\Behat\ApiContext\Infrastructure\RequestConverter\SymfonyHttpFoundationRequestConverter');
        $responseConverter = \Mockery::mock('Akamon\Behat\ApiContext\Infrastructure\ResponseConverter\SymfonyHttpFoundationResponseConverter');
        $httpKernel = \Mockery::mock('Symfony\\Component\\HttpKernel\\HttpKernelInterface');

        $client = new SymfonyHttpKernelClientRequester($requestConverter, $responseConverter);
        $client->setHttpKernel($httpKernel);

        $request = new Request('POST', '/foo');
        $response = new Response(200, 'bar', array());

        $symfonyRequest = new SymfonyRequest();
        $symfonyResponse = new SymfonyResponse();

        $requestConverter->shouldReceive('convert')->with($request)->once()->andReturn($symfonyRequest)->ordered();
        $httpKernel->shouldReceive('handle')->with($symfonyRequest)->once()->andReturn($symfonyResponse)->ordered();
        $responseConverter->shouldReceive('convert')->with($symfonyResponse)->once()->andReturn($response)->ordered();

        $this->assertSame($response, $client->request($request));
    }
}
