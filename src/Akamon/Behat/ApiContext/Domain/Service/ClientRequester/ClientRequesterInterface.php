<?php

namespace Akamon\Behat\ApiContext\Domain\Service\ClientRequester;

use Symfony\Component\HttpFoundation as Http;

interface ClientRequesterInterface
{
    /**
     * @return Http\Response
     */
    function request(Http\Request $request);
}
