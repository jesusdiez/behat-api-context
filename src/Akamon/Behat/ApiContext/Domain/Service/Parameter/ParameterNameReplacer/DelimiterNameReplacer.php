<?php

namespace Akamon\Behat\ApiContext\Domain\Service\Parameter\ParameterNameReplacer;

use felpado as f;

class DelimiterNameReplacer extends RegexNameReplacer
{
    public function __construct(array $params)
    {
        $delimiter = f\get($params, 'delimiter');

        parent::__construct($this->createRegex($delimiter));
    }

    private function createRegex($delimiter)
    {
        $delimiterQuoted = preg_quote($delimiter, '/');

        return str_replace('%delimiter%', $delimiterQuoted, '/^%delimiter%(.+)%delimiter%$/');
    }
}
