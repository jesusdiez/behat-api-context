<?php

namespace Akamon\Behat\ApiContext\Domain\ParameterAccessor\NameReplacer;

use felpado as f;

class RegexNameReplacer implements NameReplacerInterface
{
    private $regex;

    public function __construct($regex)
    {
        $this->regex = $regex;
    }

    public function hasToReplace($name)
    {
        return (Bool) preg_match($this->regex, $name);
    }

    public function nameToReplace($name)
    {
        if (!$this->hasToReplace($name)) {
            throw new \InvalidArgumentException(sprintf('The name "%s" does not have to replace.', $name));
        }

        return f\first($this->matchesForName($name));
    }

    private function matchesForName($name)
    {
        $matches = f\rest($this->matchesForRegex($name));

        if (count($matches)) {
            return $matches;
        }

        throw new \RuntimeException(sprintf('The name "%s" does not have matches.', $name));
    }

    private function matchesForRegex($string)
    {
        preg_match($this->regex, $string, $matches);

        return $matches;
    }
}
