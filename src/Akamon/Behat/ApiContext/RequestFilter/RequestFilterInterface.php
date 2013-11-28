<?php

namespace Akamon\Behat\ApiContext\RequestFilter;

use Symfony\Component\HttpFoundation\RequestFilterInterface;

interface RequestFilterInterface
{
    /**
     * @return Request
     */
    function request(Request $request);
}