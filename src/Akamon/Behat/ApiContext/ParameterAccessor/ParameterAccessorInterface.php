<?php

namespace Akamon\Behat\ApiContext\ParameterAccessor;

interface ParameterAccessorInterface
{
    function add($parameters, $name, $value);

    function has($parameters, $name);

    function get($parameters, $name);
}