<?php

namespace Akamon\Behat\ApiContext\Domain\ParameterAccessor;

use Akamon\Behat\ApiContext\Domain\ParameterAccessor\ParameterReplacer\ParameterReplacerInterface;
use Akamon\Behat\ApiContext\Domain\ParameterAccessor\NameReplacer\NameReplacerInterface;

class ReplaceParameterAccessor implements ParameterAccessorInterface
{
    private $delegate;
    private $parameterReplacer;
    private $nameReplacer;

    public function __construct(ParameterAccessorInterface $delegate, ParameterReplacerInterface $parameterReplacer, NameReplacerInterface $nameReplacer)
    {
        $this->delegate = $delegate;
        $this->parameterReplacer = $parameterReplacer;
        $this->nameReplacer = $nameReplacer;
    }

    public function add($parameters, $name, $value)
    {
        return $this->delegate->add($parameters, $name, $value);
    }

    public function has($parameters, $name)
    {
        return $this->delegate->has($parameters, $name);
    }

    public function get($parameters, $name)
    {
        if ($this->nameReplacer->hasToReplace($name)) {
            return $this->parameterReplacer->replace($this->nameReplacer->nameToReplace($name));
        }

        return $this->delegate->get($parameters, $name);
    }
}
