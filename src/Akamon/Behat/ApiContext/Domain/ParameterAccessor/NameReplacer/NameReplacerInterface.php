<?php

namespace Akamon\Behat\ApiContext\Domain\ParameterAccessor\NameReplacer;

interface NameReplacerInterface
{
    function hasToReplace($name);

    function nameToReplace($name);
}
