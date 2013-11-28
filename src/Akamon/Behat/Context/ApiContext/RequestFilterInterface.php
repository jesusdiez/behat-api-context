<?php

namespace Akamon\Behat\Context\ApiContext;

use Symfony\Component\HttpFoundation\RequestFilterInterface;

interface RequestFilterInterface
{
    /**
     * @return Request
     */
    function request(Request $request);
}