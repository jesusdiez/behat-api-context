<?php

namespace Akamon\Behat\ApiContext\Domain\Tests\ResponseParametersProcessor;

use Akamon\Behat\ApiContext\Domain\ResponseParametersProcessor\JsonResponseParametersProcessor;
use Symfony\Component\HttpFoundation\Response;

class JsonResponseParametersProcessorTest extends \PHPUnit_Framework_TestCase
{
    public function testProcessShouldDecodeTheResponseJsonContent()
    {
        $parameters = array('foo' => 'bar', 'one' => 'two');

        $processor = new JsonResponseParametersProcessor();
        $response = new Response(json_encode($parameters));

        $this->assertSame($parameters, $processor->process($response));
    }
}
