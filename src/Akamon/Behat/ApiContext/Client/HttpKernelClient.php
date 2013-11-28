<?php

namespace Akamon\Behat\ApiContext\Client;

use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class HttpKernelClient implements ClientInterface
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