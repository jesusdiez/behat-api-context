<?php

namespace Akamon\Behat\ApiContext\Domain\Service\ResponseConverter;

use Akamon\Behat\ApiContext\Domain\Model\Response;

interface ResponseConverterInterface
{
    /**
     * @return Response
     */
    function convert($response);
}
