<?php

namespace Akamon\Behat\Context;

use Akamon\Behat\Context\ApiContext\RequestCreatorInterface;
use Akamon\Behat\Context\ApiContext\ClientInterface;
use Akamon\Behat\Context\ApiContext\ParameterAccessorInterface;
use Akamon\Behat\Context\ApiContext\ResponseParametersProcessorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Behat\Behat\Context\BehatContext;
use Behat\Gherkin\Node\TableNode;

class ApiContext extends BehatContext
{
    private $client;
    private $parameterAccessor;
    private $responseParametersProcessor;

    private $requestHeaders = array();
    private $requestParameters = array();
    private $response;
    private $responseParameters;

    public function __construct(ClientInterface $client, ParameterAccessorInterface $parameterAccessor, ResponseParametersProcessorInterface $responseParametersProcessor)
    {
        $this->client = $client;
        $this->parameterAccessor = $parameterAccessor;
        $this->responseParametersProcessor = $responseParametersProcessor;
    }

    /**
     * @When /^I add a request header "([^"]*)" with "([^"]*)"$/
     */
    public function addRequestHeader($name, $value)
    {
        $this->requestHeaders[$name] = $value;
    }

    /**
     * @When /^I add the request headers:$/
     */
    public function addRequestHeaders(TableNode $table)
    {
        foreach ($table->getRows() as $row) {
            $this->addRequestHeader($row[0], $row[1]);
        }
    }

    /**
     * @When /^I add a request parameter "([^"]*)" with "([^"]*)"$/
     */
    public function addRequestParameter($name, $value)
    {
        $this->requestParameters = $this->parameterAccessor->add($this->requestParameters, $name, $value);
    }

    /**
     * @When /^I add the request parameters:$/
     */
    public function addRequestParameters(TableNode $table)
    {
        foreach ($table->getRows() as $row) {
            $this->addRequestParameter($row[0], $row[1]);
        }
    }

    /**
     * @When /^I request "([^"]*)" using the method "([^"]*)"$/
     */
    public function request($uri, $method)
    {
        $request = $this->createRequest($uri, $method);

        $response = $this->client->request($request);
        $this->setResponse($response);
    }

    protected function createRequest($uri, $method)
    {
        $request = Request::create($uri, $method);

        $request->headers->replace($this->requestHeaders);
        $request->request->replace($this->requestParameters);

        return $request;
    }

    private function setResponse(Response $response)
    {
        $this->response = $response;

        $this->responseParameters = $this->responseParametersProcessor->process($response);
    }

    private function getResponse()
    {
        return $this->response;
    }

    /**
     * @Then /^the response status code should be "([^"]*)"$/
     */
    public function theResponseStatusCodeShouldBe($expectedStatusCode)
    {
        $statusCode = $this->getResponse()->getStatusCode();

        if ($statusCode != $expectedStatusCode) {
            throw new \Exception(sprintf('The response status code is "%s" and it should be "%s".', $statusCode, $expectedStatusCode));
        }
    }

    /**
     * @Then /^the response header "([^"]*)" should be "([^"]*)"$/
     */
    public function theResponseHeaderShouldBe($name, $expectedValue)
    {
        $value = $this->getResponse()->headers->get($name);

        if ($value !== $expectedValue) {
            throw new \Exception(sprintf('The response header "%s" is "%s" and it should be "%s".', $name, $value, $expectedValue));
        }
    }

    /**
     * @Then /^the request headers should be:$/
     */
    public function theRequestHeadersShouldBe(TableNode $table)
    {
        foreach ($table->getRows() as $row) {
            $this->theResponseHeaderShouldBe($row[0], $row[1]);
        }
    }

    /**
     * @Then /^the response parameter "([^"]*)" should exist$/
     */
    public function theResponseParameterShouldExist($name)
    {
        if (!$this->parameterAccessor->has($this->responseParameters, $name)) {
            throw new \Exception(sprintf('The response parameter "%s" does not exist.', $name));
        }
    }

    /**
     * @Then /^the response parameter "([^"]*)" should be "([^"]*)"$/
     */
    public function theResponseParameterShouldBe($name, $expectedValue)
    {
        $this->theResponseParameterShouldExist($name);

        $value = $this->parameterAccessor->get($this->responseParameters, $name);

        if ($value !== $expectedValue) {
            throw new \Exception(sprintf('The response header "%s" is "%s" and it should be "%s".', $name, $value, $expectedValue));
        }
    }

    /**
     * @Then /^the response parameters should be:$/
     */
    public function theResponseParametersShouldBe(TableNode $table)
    {
        foreach ($table->getRows() as $row) {
            $this->theResponseParameterShouldBe($row[0], $row[1]);
        }
    }
}