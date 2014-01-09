<?php

namespace Akamon\Behat\ApiContext\Tests\ParameterAccessor\NameReplacer;

abstract class RegexNameReplacerTestCase extends \PHPUnit_Framework_TestCase
{
    private $nameReplacer;

    protected function setUp()
    {
        $this->nameReplacer = $this->createRegexNameReplacer();
    }

    abstract protected function createRegexNameReplacer();

    abstract protected function namesHasToReplace();

    abstract protected function namesNotHasToReplace();

    abstract protected function namesToReplace();

    public function testHasToReplaceShouldReturnTrueWhenTheNameMatchesTheRegex()
    {
        foreach ($this->namesHasToReplace() as $name) {
            $this->assertTrue($this->nameReplacer->hasToReplace($name));
        }
    }

    public function testHasToReplaceShouldReturnFalseWhenTheNameNotMatchesTheRegex()
    {
        foreach ($this->namesNotHasToReplace() as $name) {
            $this->assertFalse($this->nameReplacer->hasToReplace($name));
        }
    }

    public function testNameToReplaceShouldReturnTheFirstMatchOfTheRegex()
    {
        foreach ($this->namesToReplace() as $name => $nameToReplace) {
            $this->assertSame($nameToReplace, $this->nameReplacer->nameToReplace($name));
        }
    }
}