<?php

namespace Akamon\Behat\Context\Tests\ApiContext;

use Akamon\Behat\Context\ApiContext\JsonResponseParametersProcessor;
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