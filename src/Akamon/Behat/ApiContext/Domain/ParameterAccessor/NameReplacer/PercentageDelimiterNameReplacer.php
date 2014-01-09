<?php

namespace Akamon\Behat\ApiContext\Domain\ParameterAccessor\NameReplacer;

class PercentageDelimiterNameReplacer extends DelimiterNameReplacer
{
    public function __construct()
    {
        parent::__construct('%');
    }
}
