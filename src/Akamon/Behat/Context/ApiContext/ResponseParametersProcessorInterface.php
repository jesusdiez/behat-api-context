<?php

namespace Akamon\Behat\Context\ApiContext;

use Symfony\Component\HttpFoundation\Response;

interface ResponseParametersProcessorInterface
{
    function process(Response $response);
}