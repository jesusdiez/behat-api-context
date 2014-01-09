<?php

namespace Akamon\Behat\ApiContext\Domain\Service\RequestFilter;

use Akamon\Behat\ApiContext\Domain\Model\Request;

interface RequestFilterInterface
{
    /**
     * @return Request
     */
    function filter(Request $request);
}
