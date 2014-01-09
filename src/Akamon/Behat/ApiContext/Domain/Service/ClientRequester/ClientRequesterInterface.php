<?php

namespace Akamon\Behat\ApiContext\Domain\Service\ClientRequester;

use Akamon\Behat\ApiContext\Domain\Model\Request;
use Akamon\Behat\ApiContext\Domain\Model\Response;

interface ClientRequesterInterface
{
    /**
     * @return Response
     */
    function request(Request $request);
}
