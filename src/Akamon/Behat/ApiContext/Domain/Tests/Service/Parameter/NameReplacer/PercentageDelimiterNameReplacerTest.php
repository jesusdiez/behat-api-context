<?php

namespace Akamon\Behat\ApiContext\Domain\Tests\Service\Parameter\NameReplacer;

use Akamon\Behat\ApiContext\Domain\Service\Parameter\ParameterNameReplacer\PercentageDelimiterNameReplacer;

class PercentageDelimiterNameReplacerTest extends RegexNameReplacerTestCase
{
    protected function createRegexNameReplacer()
    {
        return new PercentageDelimiterNameReplacer();
    }

    protected function namesHasToReplace()
    {
        return array('%foo%', '%bar%');
    }

    protected function namesNotHasToReplace()
    {
        return array('%foo', 'bar%', 'ups');
    }

    protected function namesToReplace()
    {
        return array(
            '%foo%' => 'foo',
            '%bar%' => 'bar'
        );
    }
}
