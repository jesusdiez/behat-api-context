<?php

namespace Akamon\Behat\ApiContext\Domain\Tests\Service\ResponseParametersProcessor;

use Akamon\Behat\ApiContext\Domain\Service\ResponseParametersProcessor\JsonResponseParametersProcessor;
use Akamon\Behat\ApiContext\Domain\Model\Response;

class JsonResponseParametersProcessorTest extends \PHPUnit_Framework_TestCase
{
    public function testProcessShouldDecodeTheResponseJsonContent()
    {
        $parameters = array('foo' => 'bar', 'one' => 'two');

        $processor = new JsonResponseParametersProcessor();
        $response = new Response(200, json_encode($parameters), array());

        $this->assertSame($parameters, $processor->process($response));
    }
}
