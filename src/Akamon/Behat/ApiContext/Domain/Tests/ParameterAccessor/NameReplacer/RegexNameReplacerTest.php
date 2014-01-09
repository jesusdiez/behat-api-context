<?php

namespace Akamon\Behat\ApiContext\Domain\Tests\ParameterAccessor\NameReplacer;

use Akamon\Behat\ApiContext\Domain\ParameterAccessor\NameReplacer\RegexNameReplacer;

class RegexNameReplacerTest extends RegexNameReplacerTestCase
{
    protected function createRegexNameReplacer()
    {
        return new RegexNameReplacer('/^%(.+)%$/');
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

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testNameToReplaceThrowsAnInvalidArgumentExceptionWhenTheNameNotHasToReplace()
    {
        $nameReplacer = new RegexNameReplacer('/^%(.+)%$/');
        $nameReplacer->nameToReplace('foo');
    }

    /**
     * @expectedException \RuntimeException
     */
    public function testNameToReplaceThrowsARuntimeExceptionWhenThereAreNoMatches()
    {
        $nameReplacer = new RegexNameReplacer('/^%.+%$/');
        $nameReplacer->nameToReplace('%foo%');
    }
}
