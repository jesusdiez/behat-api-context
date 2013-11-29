<?php

namespace Akamon\Behat\ApiContext\ResponseParametersProcessor;

use Symfony\Component\HttpFoundation\Response;

class JsonResponseParametersProcessor implements ResponseParametersProcessorInterface
{
    public function process(Response $response)
    {
        return json_decode($response->getContent(), true);
    }
}