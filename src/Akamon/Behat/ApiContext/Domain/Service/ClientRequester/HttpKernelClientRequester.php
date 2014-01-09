<?php

namespace Akamon\Behat\ApiContext\Domain\Service\ClientRequester;

use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class HttpKernelClientRequester implements ClientRequesterInterface
{
    private $httpKernel;

    public function setHttpKernel(HttpKernelInterface $httpKernel)
    {
        $this->httpKernel = $httpKernel;
    }

    public function request(Request $request)
    {
        return $this->httpKernel->handle($request);
    }
}
