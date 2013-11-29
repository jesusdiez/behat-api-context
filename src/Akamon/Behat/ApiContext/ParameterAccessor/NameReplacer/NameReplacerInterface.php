<?php

namespace Akamon\Behat\ApiContext\ParameterAccessor\NameReplacer;

interface NameReplacerInterface
{
    function hasToReplace($name);

    function nameToReplace($name);
}