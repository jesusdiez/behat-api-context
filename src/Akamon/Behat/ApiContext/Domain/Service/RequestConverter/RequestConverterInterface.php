<?php

namespace Akamon\Behat\ApiContext\Domain\Service\RequestConverter;

use Akamon\Behat\ApiContext\Domain\Model\Request;

interface RequestConverterInterface
{
    function convert(Request $request);
}
