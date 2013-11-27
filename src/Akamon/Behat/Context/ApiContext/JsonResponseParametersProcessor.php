<?php

namespace Akamon\Behat\Context\ApiContext;

use Symfony\Component\HttpFoundation\Response;

class JsonResponseParametersProcessor implements ResponseParametersProcessorInterface
{
    public function process(Response $response)
    {
        return json_decode($response->getContent(), true);
    }
}