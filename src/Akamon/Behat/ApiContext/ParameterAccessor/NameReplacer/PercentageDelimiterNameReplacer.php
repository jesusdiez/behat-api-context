<?php

namespace Akamon\Behat\ApiContext\ParameterAccessor\NameReplacer;

class PercentageDelimiterNameReplacer extends DelimiterNameReplacer
{
    public function __construct()
    {
        parent::__construct('%');
    }
}