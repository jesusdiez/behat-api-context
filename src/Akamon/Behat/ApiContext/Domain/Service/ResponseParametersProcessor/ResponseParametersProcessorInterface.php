<?php

namespace Akamon\Behat\ApiContext\Domain\Service\ResponseParametersProcessor;

use Akamon\Behat\ApiContext\Domain\Model\Response;

interface ResponseParametersProcessorInterface
{
    function process(Response $response);
}
