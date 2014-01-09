<?php

namespace Akamon\Behat\ApiContext\Domain\Tests\ParameterAccessor\ParameterReplacer;

use Akamon\Behat\ApiContext\Domain\ParameterAccessor\ReplaceParameterAccessor;
use Akamon\Behat\ApiContext\Domain\ParameterAccessor\NameReplacer\PercentageDelimiterNameReplacer;

class ReplaceParameterAccessorTest extends \PHPUnit_Framework_TestCase
{
    private $delegate;
    private $parameterReplacer;
    private $accessor;

    protected function setUp()
    {
        $this->delegate = \Mockery::mock('Akamon\Behat\ApiContext\Domain\ParameterAccessor\ParameterAccessorInterface');
        $this->parameterReplacer = \Mockery::mock('Akamon\Behat\ApiContext\Domain\ParameterAccessor\ParameterReplacer\ParameterReplacerInterface');
        $this->nameReplacer = new PercentageDelimiterNameReplacer();

        $this->accessor = new ReplaceParameterAccessor($this->delegate, $this->parameterReplacer, $this->nameReplacer);
    }

    public function testAddDelegates()
    {
        $parameters = array('foo' => 'bar');
        $name = 'ups';
        $value = 'one';
        $return = new \stdClass();

        $this->delegate
            ->shouldReceive('add')
            ->once()
            ->with($parameters, $name, $value)
            ->andReturn($return);

        $this->assertSame($return, $this->accessor->add($parameters, $name, $value));
    }

    public function testHasDelegates()
    {
        $parameters = array('foo' => 'bar');
        $name = 'ups';
        $return = new \stdClass();

        $this->delegate
            ->shouldReceive('has')
            ->once()
            ->with($parameters, $name)
            ->andReturn($return);

        $this->assertSame($return, $this->accessor->has($parameters, $name));
    }

    public function testGetDelegatesWhenTheNameNotMatchesTheReplaceRegex()
    {
        $parameters = array('foo' => 'bar');
        $name = 'ups';
        $return = new \stdClass();

        $this->delegate
            ->shouldReceive('get')
            ->once()
            ->with($parameters, $name)
            ->andReturn($return);

        $this->assertSame($return, $this->accessor->get($parameters, $name));
    }

    public function testGetReplacesWhenTheNameMatchesTheReplaceRegex()
    {
        $parameters = array('foo' => 'bar');
        $name = '%ups%';
        $return = new \stdClass();

        $this->parameterReplacer
            ->shouldReceive('replace')
            ->once()
            ->with('ups')
            ->andReturn($return);

        $this->assertSame($return, $this->accessor->get($parameters, $name));
    }
}
