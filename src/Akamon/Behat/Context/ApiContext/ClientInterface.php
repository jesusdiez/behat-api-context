<?php

namespace Akamon\Behat\Context\ApiContext;

use Symfony\Component\HttpFoundation\Request;

interface ClientInterface
{
    /**
     * @return Response
     */
    function request(Request $request);
}