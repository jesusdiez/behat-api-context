<?php

namespace Akamon\Behat\Context\ApiContext;

use Symfony\Component\HttpFoundation as Http;

interface ClientInterface
{
    /**
     * @return Http\Response
     */
    function request(Http\Request $request);
}
