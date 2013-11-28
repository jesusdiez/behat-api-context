<?php

namespace Akamon\Behat\ApiContext\Client;

use Symfony\Component\HttpFoundation as Http;

interface ClientInterface
{
    /**
     * @return Http\Response
     */
    function request(Http\Request $request);
}
