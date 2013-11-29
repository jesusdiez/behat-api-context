<?php

namespace Akamon\Behat\ApiContext\ParameterAccessor\NameReplacer;

class AsteriskDelimiterNameReplacer extends DelimiterNameReplacer
{
    public function __construct()
    {
        parent::__construct('*');
    }
}