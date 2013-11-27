<?php

namespace Akamon\Behat\Context\ApiContext;

interface ParameterAccessorInterface
{
    function add($parameters, $name, $value);

    function has($parameters, $name);

    function get($parameters, $name);
}