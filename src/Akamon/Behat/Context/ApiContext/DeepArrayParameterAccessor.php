<?php

namespace Akamon\Behat\Context\ApiContext;

use Felpado as f;
use Symfony\Component\HttpFoundation\Response;

class DeepArrayParameterAccessor implements ParameterAccessorInterface
{
    private $depthSeparator;

    public function __construct($depthSeparator)
    {
        $this->depthSeparator = $depthSeparator;
    }

    public function add($parameters, $name, $value)
    {
        return f::assocIn($parameters, $this->depthForName($name), $value);
    }

    public function has($parameters, $name)
    {
        return f::containsIn($parameters, $this->depthForName($name));
    }

    public function get($parameters, $name)
    {
        if (!$this->has($parameters, $name)) {
            throw new \InvalidArgumentException(sprintf('The parameter "%s" does not exist.', $name));
        }

        return f::getIn($parameters, $this->depthForName($name));
    }

    private function depthForName($name)
    {
        return explode($this->depthSeparator, $name);
    }
}