<?php

namespace Akamon\Behat\ApiContext\Domain;

use Akamon\Behat\ApiContext\Domain\Service\ClientRequester\ClientRequesterInterface;
use Akamon\Behat\ApiContext\Domain\Service\Parameter\ParameterAccessor\ParameterAccessorInterface;
use Akamon\Behat\ApiContext\Domain\Service\ResponseParametersProcessor\ResponseParametersProcessorInterface;
use Akamon\Behat\ApiContext\Domain\Service\RequestFilter\RequestFilterInterface;
use Akamon\Behat\ApiContext\Domain\Model\Request;
use Akamon\Behat\ApiContext\Domain\Model\Response;
use Behat\Behat\Context\BehatContext;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;
use felpado as f;

class ApiContext extends BehatContext
{
    private $client;
    private $parameterAccessor;
    private $responseParametersProcessor;

    /** @var RequestFilterInterface */
    private $requestFilter;

    private $requestHeaders = array();
    private $requestParameters = array();
    private $requestContent;

    /** @var Response */
    private $response;
    private $responseParameters;

    public function __construct(ClientRequesterInterface $client, ParameterAccessorInterface $parameterAccessor, ResponseParametersProcessorInterface $responseParametersProcessor)
    {
        $this->client = $client;
        $this->parameterAccessor = $parameterAccessor;
        $this->responseParametersProcessor = $responseParametersProcessor;
    }

    public function setRequestFilter(RequestFilterInterface $requestFilter)
    {
        $this->requestFilter = $requestFilter;
    }

    /**
     * @When /^I add the request header "(.*)" with "(.*)"$/
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
     * @When /^I add the http basic authentication with "(.*)" and "(.*)"$/
     */
    public function addHttpBasicAuthentication($username, $password)
    {
        $this->addRequestHeader('AUTHORIZATION', 'Basic ' . base64_encode($username . ':' . $password));
    }

    /**
     * @When /^I add the request parameter "(.*)" with "(.*)"$/
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
        foreach ($this->parametersFromTable($table) as $name => $value) {
            $this->addRequestParameter($name, $value);
        }
    }

    private function parametersFromTable(TableNode $table)
    {
        return f\rename_keys(
            f\map(function ($v) {
                return f\first(f\rest($v));
            }, $table->getRows()),
            f\map('felpado\first', $table->getRows())
        );
    }

    /**
     * @When /^I set the request content:$/
     */
    public function setRequestContent(PyStringNode $string)
    {
        $this->requestContent = $string->getRaw();
    }

    /**
     * @When /^I make a "(.*)" request to "(.*)"$/
     */
    public function request($method, $uri)
    {
        $request = $this->createRequest($method, $uri);

        $response = $this->client->request($request);
        $this->requestParameters = array();
        $this->requestHeaders = array();
        $this->requestContent = array();

        $this->setResponse($response);
    }

    private function createRequest($method, $uri)
    {
        $request = new Request($method, $uri);
        $request->setParameters($this->requestParameters);
        $request->setHeaders($this->requestHeaders);
        $request->setContent($this->requestContent);

        return $this->filterRequest($request);
    }

    private function filterRequest(Request $request)
    {
        if ($this->requestFilter) {
            return $this->requestFilter->filter($request);
        }
        return $request;
    }

    private function setResponse(Response $response)
    {
        $this->response = $response;

        $this->responseParameters = $this->responseParametersProcessor->process($response);
    }

    /**
     * @return Response
     */
    public function getResponse()
    {
        if ($this->response === null) {
            throw new \RuntimeException('There is no response.');
        }

        return $this->response;
    }

    public function getResponseParameters()
    {
        if ($this->responseParameters === null) {
            throw new \RuntimeException('There are no response parameters.');
        }

        return $this->responseParameters;
    }

    public function getResponseParameter($name)
    {
        return $this->parameterAccessor->get($this->getResponseParameters(), $name);
    }

    /**
     * @When /^I make a "(.*)" request to "(.*)" with the parameters:$/
     */
    public function requestWith($method, $uri, TableNode $table)
    {
        $this->addRequestParameters($table);
        $this->request($method, $uri);
    }

    /**
     * @Then /^the response status code should be "(.*)"$/
     */
    public function checkResponseStatusCode($expectedStatusCode)
    {
        $statusCode = $this->getResponse()->getStatusCode();

        if ($statusCode != $expectedStatusCode) {
            throw new \Exception(sprintf('The response status code is "%s" and it should be "%s".', $statusCode, $expectedStatusCode));
        }
    }

    /**
     * @Then /^the response header "(.*)" should be "(.*)"$/
     */
    public function checkResponseHeader($name, $expectedValue)
    {
        $value = f\get_or($this->response->getHeaders(), $name, null);

        if ($value !== $expectedValue) {
            throw new \Exception(sprintf('The response header "%s" is "%s" and it should be "%s".', $name, $value, $expectedValue));
        }
    }

    /**
     * @Then /^the request headers should be:$/
     */
    public function checkResponseHeaders(TableNode $table)
    {
        foreach ($table->getRows() as $row) {
            $this->checkResponseHeader($row[0], $row[1]);
        }
    }

    /**
     * @Then /^the response parameter "(.*)" should exist$/
     */
    public function checkResponseParameterExists($name)
    {
        if (!$this->parameterAccessor->has($this->responseParameters, $name)) {
            throw new \Exception(sprintf('The response parameter "%s" does not exist.', $name));
        }
    }

    /**
     * @Then /^the response parameters should exist:$/
     */
    public function checkResponseParametersExist(TableNode $table)
    {
        foreach ($table->getRows() as $row) {
            $this->checkResponseParameterExists($row[0]);
        }
    }

    /**
     * @Then /^the response parameter "(.*)" should be "(.*)"$/
     */
    public function checkResponseParameter($name, $expectedValue)
    {
        $this->checkResponseParameterExists($name);

        $value = $this->parameterAccessor->get($this->responseParameters, $name);

        if ($value != $expectedValue) {
            throw new \Exception(sprintf('The response parameter "%s" is "%s" and it should be "%s".', $name, $value, $expectedValue));
        }
    }

    /**
     * @Then /^the response parameters should be:$/
     */
    public function checkResponseParameters(TableNode $table)
    {
        foreach ($table->getRows() as $row) {
            $this->checkResponseParameter($row[0], $row[1]);
        }
    }

    /**
     * @Then /^the response parameter "(.*)" should match "(.*)"$/
     */
    public function checkResponseParameterMatchs($name, $regex)
    {
        $this->checkResponseParameterExists($name);

        $value = $this->parameterAccessor->get($this->responseParameters, $name);

        if (!preg_match($regex, $value)) {
            throw new \Exception(sprintf('The response parameter "%s" is "%s" and it should match "%s" but it does not.', $name, $value, $regex));
        }
    }

    /**
     * @Then /^the response parameters should match:$/
     */
    public function checkResponseParametersMatch(TableNode $table)
    {
        foreach ($table->getRows() as $row) {
            $this->checkResponseParameterMatchs($row[0], $row[1]);
        }
    }

    /**
     * @Then /^the response parameter "(.*)" should not match "(.*)"$/
     */
    public function checkResponseParameterNotMatchs($name, $regex)
    {
        $this->checkResponseParameterExists($name);

        $value = $this->parameterAccessor->get($this->responseParameters, $name);

        if (preg_match($regex, $value)) {
            throw new \Exception(sprintf('The response parameter "%s" is "%s" and it should not match "%s" but it does.', $name, $value, $regex));
        }
    }

    /**
     * @Then /^the response content should be:$/
     */
    public function theResponseContentShouldBe(PyStringNode $string)
    {
        if ($string->getRaw() !== $this->getResponse()->getContent()) {
            throw new \Exception(sprintf('The response content is "%s" and it should be "%s"', $this->getResponse()->getContent(), $string->getRaw()));
        }
    }

    /**
     * @Then /^the response content should match "([^"]*)"$/
     */
    public function theResponseContentShouldNotMatch($regex)
    {
        $content = $this->getResponse()->getContent();

        if (f\not(preg_match($regex, $content))) {
            throw new \Exception(sprintf('The response content is "%s" and it should match "%s", but it does not.', $content, $regex));
        }
    }

    /**
     * @Then /^the response content should not match "([^"]*)"$/
     */
    public function theResponseContentShouldMatch($regex)
    {
        $content = $this->getResponse()->getContent();

        if (preg_match($regex, $content)) {
            throw new \Exception(sprintf('The response content is "%s" and it should not match "%s", but it does.', $content, $regex));
        }
    }

    /**
     * @Then /^print last response$/
     */
    public function printLastResponse()
    {
        $this->printDebug($this->getResponse());
    }
}
