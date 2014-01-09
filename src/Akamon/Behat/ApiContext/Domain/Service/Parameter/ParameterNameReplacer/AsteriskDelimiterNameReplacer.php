<?php

namespace Akamon\Behat\ApiContext\Domain\Service\Parameter\ParameterNameReplacer;

class AsteriskDelimiterNameReplacer extends DelimiterNameReplacer
{
    public function __construct()
    {
        parent::__construct('*');
    }
}
