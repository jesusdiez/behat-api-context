<?php

use Behat\Behat\Context\ClosuredContextInterface,
    Behat\Behat\Context\TranslatedContextInterface,
    Behat\Behat\Context\BehatContext,
    Behat\Behat\Exception\PendingException;
use Behat\Gherkin\Node\PyStringNode,
    Behat\Gherkin\Node\TableNode;

use Akamon\Behat\ApiContext\Domain\ApiContext;
use Akamon\Behat\ApiContext\Domain\Service\ClientRequester\ClientRequesterInterface;
use Akamon\Behat\ApiContext\Domain\Service\Parameter\ParameterAccessor\DeepArrayParameterAccessor;
use Akamon\Behat\ApiContext\Domain\Service\ResponseParametersProcessor\JsonResponseParametersProcessor;
use Akamon\Behat\ApiContext\Domain\Model\Request;
use Akamon\Behat\ApiContext\Domain\Model\Response;
use felpado as f;

class FeatureContext extends BehatContext
{
    public function __construct()
    {
        $this->useContext('api_context', $this->createApiContext());
    }

    private function createApiContext()
    {
        return new ApiContext(
            new TestingClient(),
            new DeepArrayParameterAccessor('.'),
            new JsonResponseParametersProcessor()
        );
    }
}

class TestingClient implements ClientRequesterInterface
{
    public function request(Request $request)
    {
        $statusCode = f\get_or($request->getParameters(), 'statusCode', 200);
        $content = $request->getParameters() ?
            json_encode($request->getParameters()) :
            $request->getContent();
        $headers = $request->getHeaders();

        return new Response($statusCode, $content, $headers);
    }
}
