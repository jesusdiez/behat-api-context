<?php

namespace Akamon\Behat\ApiContext\Infrastructure\ClientRequester;

use Akamon\Behat\ApiContext\Domain\Service\ClientRequester\ClientRequesterInterface;
use Akamon\Behat\ApiContext\Infrastructure\RequestConverter\SymfonyHttpFoundationRequestConverter;
use Akamon\Behat\ApiContext\Infrastructure\ResponseConverter\SymfonyHttpFoundationResponseConverter;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Akamon\Behat\ApiContext\Domain\Model\Request;

class SymfonyHttpKernelClientRequester implements ClientRequesterInterface
{
    private $requestConverter;
    private $responseConverter;

    /** @var HttpKernelInterface */
    private $httpKernel;

    public function __construct(SymfonyHttpFoundationRequestConverter $requestConverter, SymfonyHttpFoundationResponseConverter $responseConverter)
    {
        $this->requestConverter = $requestConverter;
        $this->responseConverter = $responseConverter;
    }


    public function setHttpKernel(HttpKernelInterface $httpKernel)
    {
        $this->httpKernel = $httpKernel;
    }

    public function request(Request $request)
    {
        $symfonyRequest = $this->requestConverter->convert($request);
        $symfonyResponse = $this->httpKernel->handle($symfonyRequest);

        return $this->responseConverter->convert($symfonyResponse);
    }
}
