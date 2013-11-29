<?php

namespace Akamon\Behat\ApiContext\Tests\ParameterAccessor\NameReplacer;

use Akamon\Behat\ApiContext\ParameterAccessor\NameReplacer\DelimiterNameReplacer;

class DelimiterNameReplacerTest extends RegexNameReplacerTestCase
{
    protected function createRegexNameReplacer()
    {
        return new DelimiterNameReplacer('#');
    }

    protected function namesHasToReplace()
    {
        return array('#foo#', '#bar#');
    }

    protected function namesNotHasToReplace()
    {
        return array('#foo', 'bar#', 'ups');
    }

    protected function namesToReplace()
    {
        return array(
            '#foo#' => 'foo',
            '#bar#' => 'bar'
        );
    }
}