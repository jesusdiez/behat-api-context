<?php

namespace Akamon\Behat\ApiContext\Domain\Tests\ParameterAccessor\NameReplacer;

use Akamon\Behat\ApiContext\Domain\ParameterAccessor\NameReplacer\DelimiterNameReplacer;

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
