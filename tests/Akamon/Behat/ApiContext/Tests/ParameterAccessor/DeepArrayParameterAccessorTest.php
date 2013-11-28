<?php

namespace Akamon\Behat\Tests\ApiContext\ParameterAccessor;

use Akamon\Behat\ApiContext\ParameterAccessor\DeepArrayParameterAccessor;

class DeepArrayParameterAccessorTest extends \PHPUnit_Framework_TestCase
{
    private $accessor;

    private $parameters = array(
        'one' => 'foo',
        'two' => 'bar',
        'three' => array(
            'four' => 'foobar',
            'five' => 'barfoo',
            'six' => array('seven' => 'ups')
        )
    );

    protected function setUp()
    {
        $this->accessor = new DeepArrayParameterAccessor('.');
    }

    public function testAddShouldAddAParameter()
    {
        $initialParameters = array('one' => 'foo');
        $parameters = $this->accessor->add($initialParameters, 'two', 'bar');

        $this->assertSame(array('one' => 'foo', 'two' => 'bar'), $parameters);
    }

    public function testAddShouldAddADeepParameter()
    {
        $initialParameters = array('one' => 'foo');
        $parameters = $this->accessor->add($initialParameters, 'three.six.seven', 'ups');

        $this->assertSame(array(
            'one' => 'foo',
            'three' => array('six' => array('seven' => 'ups'))
        ), $parameters);
    }

    public function testHasShouldReturnTrueWhenAParameterExists()
    {
        $this->assertTrue($this->accessor->has($this->parameters, 'one'));
        $this->assertTrue($this->accessor->has($this->parameters, 'two'));
    }

    public function testHasShouldReturnFalseWhenAParameterExists()
    {
        $this->assertFalse($this->accessor->has($this->parameters, 'no'));
        $this->assertFalse($this->accessor->has($this->parameters, 'four'));
    }

    public function testHasShouldReturnTrueWhenADeepParameterExists()
    {
        $this->assertTrue($this->accessor->has($this->parameters, 'three.four'));
        $this->assertTrue($this->accessor->has($this->parameters, 'three.six.seven'));
    }

    public function testHasShouldReturnFalseWhenADeepParameterNotExists()
    {
        $this->assertFalse($this->accessor->has($this->parameters, 'no.no'));
        $this->assertFalse($this->accessor->has($this->parameters, 'no.one'));
    }

    public function testGetShouldReturnAParameter()
    {
        $this->assertSame('foo', $this->accessor->get($this->parameters, 'one'));
        $this->assertSame('bar', $this->accessor->get($this->parameters, 'two'));
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testGetShouldThrowAnInvalidargumentExceptionIfAParameterDoesNotExist()
    {
        $this->accessor->get($this->parameters, 'no');
    }

    public function testGetShouldReturnAValueOfADeepParameter()
    {
        $this->assertSame('foobar', $this->accessor->get($this->parameters, 'three.four'));
        $this->assertSame('ups', $this->accessor->get($this->parameters, 'three.six.seven'));
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testGetShouldThrowAnInvalidargumentExceptionIfADeepParameterDoesNotExist()
    {
        $this->accessor->get($this->parameters, 'no.no');
        $this->accessor->get($this->parameters, 'no.foo');
    }
}