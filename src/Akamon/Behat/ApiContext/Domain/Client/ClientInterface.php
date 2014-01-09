<?php

namespace Akamon\Behat\ApiContext\Domain\Client;

use Symfony\Component\HttpFoundation as Http;

interface ClientInterface
{
    /**
     * @return Http\Response
     */
    function request(Http\Request $request);
}
