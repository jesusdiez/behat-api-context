<?php

namespace Akamon\Behat\ApiContext\Domain\Service\Parameter\ParameterNameReplacer;

interface NameReplacerInterface
{
    function hasToReplace($name);

    function nameToReplace($name);
}
