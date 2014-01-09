<?php

namespace Akamon\Behat\ApiContext\Infrastructure\RequestConverter;

use Akamon\Behat\ApiContext\Domain\Model\Request;
use Symfony\Component\HttpFoundation\Request as SymfonyRequest;
use Akamon\Behat\ApiContext\Domain\Service\RequestConverter\RequestConverterInterface;
use felpado as f;

class SymfonyHttpFoundationRequestConverter implements RequestConverterInterface
{
    public function convert(Request $request)
    {
        $headers = $request->getHeaders();
        $keysMap = f\map_indexed(function ($v, $k) {
            return 'HTTP_' . $k;
        }, $headers);
        $server = f\rename_keys($headers, $keysMap);

        return SymfonyRequest::create(
            $request->getUri(),
            $request->getMethod(),
            $request->getParameters(),
            $cookies = array(),
            $files = array(),
            $server,
            $request->getContent()
        );
    }
}
