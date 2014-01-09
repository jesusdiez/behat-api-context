<?php

namespace Akamon\Behat\ApiContext\Domain\Service\Parameter\ParameterAccessor;

use felpado as f;

class DeepArrayParameterAccessor implements ParameterAccessorInterface
{
    private $params;

    public function __construct(array $params)
    {
        $this->params = f\fill_validating_or_throw($params, array(
            'separator' => f\required(array('v' => 'is_string'))
        ));
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
        return explode(f\get($this->params, 'separator'), $name);
    }
}
