<?php

namespace Akamon\Behat\ApiContext\Domain\Service\ResponseParametersProcessor;

use Symfony\Component\HttpFoundation\Response;

interface ResponseParametersProcessorInterface
{
    function process(Response $response);
}
