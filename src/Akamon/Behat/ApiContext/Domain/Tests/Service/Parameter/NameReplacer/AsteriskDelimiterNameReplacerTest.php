<?php

namespace Akamon\Behat\ApiContext\Domain\Tests\Service\Parameter\NameReplacer;

use Akamon\Behat\ApiContext\Domain\Service\Parameter\ParameterNameReplacer\AsteriskDelimiterNameReplacer;

class AsteriskDelimiterNameReplacerTest extends RegexNameReplacerTestCase
{
    protected function createRegexNameReplacer()
    {
        return new AsteriskDelimiterNameReplacer();
    }

    protected function namesHasToReplace()
    {
        return array('*foo*', '*bar*');
    }

    protected function namesNotHasToReplace()
    {
        return array('*foo', 'bar*', 'ups');
    }

    protected function namesToReplace()
    {
        return array(
            '*foo*' => 'foo',
            '*bar*' => 'bar'
        );
    }
}
