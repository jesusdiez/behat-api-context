<?php

namespace Akamon\Behat\ApiContext\Domain\ParameterAccessor;

use felpado as f;

class DeepArrayParameterAccessor implements ParameterAccessorInterface
{
    private $depthSeparator;

    public function __construct($depthSeparator)
    {
        $this->depthSeparator = $depthSeparator;
    }

    public function add($parameters, $name, $value)
    {
        return f\assoc_in($parameters, $this->depthForName($name), $value);
    }

    public function has($parameters, $name)
    {
        return f\contains_in($parameters, $this->depthForName($name));
    }

    public function get($parameters, $name)
    {
        if (!$this->has($parameters, $name)) {
            throw new \InvalidArgumentException(sprintf('The parameter "%s" does not exist.', $name));
        }

        return f\get_in($parameters, $this->depthForName($name));
    }

    private function depthForName($name)
    {
        return explode($this->depthSeparator, $name);
    }
}
