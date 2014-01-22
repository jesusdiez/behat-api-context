<?php

namespace Akamon\Behat\ApiContext\Infrastructure\RequestConverter;

use Akamon\Behat\ApiContext\Domain\Model\Request;
use Akamon\Behat\ApiContext\Domain\Service\RequestConverter\RequestConverterInterface;
use Symfony\Component\HttpFoundation\Request as SymfonyRequest;

class SymfonyHttpFoundationRequestCleanConverter implements RequestConverterInterface
{
    /**
     * @var RequestConverterInterface
     */
    private $converter;

    function __construct(RequestConverterInterface $converter)
    {
        $this->converter = $converter;
    }

    /**
     * @return SymfonyRequest
     */
    public function convert(Request $request)
    {
        $symfonyRequest = $this->converter->convert($request);

        $this->cleanRequest($request, $symfonyRequest);

        return $symfonyRequest;
    }

    private function cleanRequest(Request $request, SymfonyRequest $symfonyRequest)
    {
        if (!array_key_exists('Accept', $request->getHeaders())) {
            $symfonyRequest->headers->remove('Accept');
        }
    }
}
