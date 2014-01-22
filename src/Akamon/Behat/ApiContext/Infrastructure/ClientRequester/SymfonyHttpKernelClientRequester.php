<?php

namespace Akamon\Behat\ApiContext\Infrastructure\ClientRequester;

use Akamon\Behat\ApiContext\Domain\Model\Request;
use Akamon\Behat\ApiContext\Domain\Service\ClientRequester\ClientRequesterInterface;
use Akamon\Behat\ApiContext\Domain\Service\RequestConverter\RequestConverterInterface;
use Akamon\Behat\ApiContext\Domain\Service\ResponseConverter\ResponseConverterInterface;
use Symfony\Component\HttpKernel\HttpKernelInterface;

class SymfonyHttpKernelClientRequester implements ClientRequesterInterface
{
    private $requestConverter;

    private $responseConverter;

    /** @var HttpKernelInterface */
    private $httpKernel;

    public function __construct(
        RequestConverterInterface $requestConverter,
        ResponseConverterInterface $responseConverter
    ) {
        $this->requestConverter  = $requestConverter;
        $this->responseConverter = $responseConverter;
    }

    public function setHttpKernel(HttpKernelInterface $httpKernel)
    {
        $this->httpKernel = $httpKernel;
    }

    public function request(Request $request)
    {
        $symfonyRequest  = $this->requestConverter->convert($request);
        $symfonyResponse = $this->httpKernel->handle($symfonyRequest);

        return $this->responseConverter->convert($symfonyResponse);
    }
}
