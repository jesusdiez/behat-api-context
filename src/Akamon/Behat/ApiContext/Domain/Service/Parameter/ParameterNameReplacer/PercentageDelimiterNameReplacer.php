<?php

namespace Akamon\Behat\ApiContext\Domain\Service\Parameter\ParameterNameReplacer;

class PercentageDelimiterNameReplacer extends DelimiterNameReplacer
{
    public function __construct()
    {
        parent::__construct(array('delimiter' => '%'));
    }
}
