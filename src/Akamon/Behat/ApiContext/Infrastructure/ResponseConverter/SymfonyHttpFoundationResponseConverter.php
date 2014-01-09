<?php

namespace Akamon\Behat\ApiContext\Infrastructure\ResponseConverter;

use Akamon\Behat\ApiContext\Domain\Model\Response;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;
use Akamon\Behat\ApiContext\Domain\Service\ResponseConverter\ResponseConverterInterface;
use felpado as f;

class SymfonyHttpFoundationResponseConverter implements ResponseConverterInterface
{
    /**
     * @param $response SymfonyResponse
     *
     * @return Response
     */
    public function convert($response)
    {
        $headers = f\map_indexed(function ($_, $k) use ($response) {
            return $response->headers->get($k);
        }, $response->headers->all());

        return new Response($response->getStatusCode(), $response->getContent(), $headers);
    }
}
