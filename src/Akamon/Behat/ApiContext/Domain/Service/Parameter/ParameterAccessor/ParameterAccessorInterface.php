<?php

namespace Akamon\Behat\ApiContext\Domain\Service\Parameter\ParameterAccessor;

interface ParameterAccessorInterface
{
    function add($parameters, $name, $value);

    function has($parameters, $name);

    function get($parameters, $name);
}
