<?php

namespace Akamon\Behat\ApiContext\RequestFilter;

use Symfony\Component\HttpFoundation\Request;

interface RequestFilterInterface
{
    /**
     * @return Request
     */
    function filter(Request $request);
}