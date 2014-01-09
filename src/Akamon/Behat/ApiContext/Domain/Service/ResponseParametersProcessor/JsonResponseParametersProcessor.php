<?php

namespace Akamon\Behat\ApiContext\Domain\Service\ResponseParametersProcessor;

use Akamon\Behat\ApiContext\Domain\Model\Response;

class JsonResponseParametersProcessor implements ResponseParametersProcessorInterface
{
    public function process(Response $response)
    {
        return json_decode($response->getContent(), true);
    }
}
