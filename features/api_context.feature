Feature: ApiContext
    In order to test an Api
    As a Api creator
    I want to use the ApiContext

    Scenario Outline: StatusCode
        When I make a "GET" request to "/users?status_code=<statusCode>"
        Then the response status code should be "<statusCode>"

        Examples:
        | statusCode |
        | 200        |
        | 404        |
        | 500        |

    Scenario: Single Headers
        When I add the request header "accept-language" with "es"
        And I add the request header "accept" with "text/xml"
        And I make a "POST" request to "/users"
        Then the response header "accept-language" should be "es"
        Then the response header "accept" should be "text/xml"

    Scenario: Multiple Headers
        When I add the request headers:
            | accept-language | es       |
            | accept          | text/xml |
        And I make a "POST" request to "/users"
        Then the request headers should be:
            | accept-language | es       |
            | accept          | text/xml |

    Scenario: Basic Authentication
        When I add the http basic authentication with "pablodip" and "pass"
        And I make a "POST" request to "/users"
        Then the response header "authorization" should be "Basic cGFibG9kaXA6cGFzcw=="

    Scenario: Single Parameters
        When I add the request parameter "one" with "foo"
        And I add the request parameter "two" with "bar"
        And I add the request parameter "three" with "10"
        And I make a "POST" request to "/users"
        Then the response parameter "one" should exist
        And the response parameter "one" should be "foo"
        And the response parameter "two" should be "bar"
        And the response parameter "three" should match "/\d+/"
        And the response parameter "three" should not match "/[a-z]+/"

    Scenario: Multiple Parameters:
        When I add the request parameters:
            | one   | foo |
            | two   | bar |
            | three | 10  |
        And I make a "POST" request to "/users"
        Then the response parameters should exist:
            | one   |
            | two   |
            | three |
        And the response parameters should match:
            | one   | /o/   |
            | three | /\d+/ |
        And the response parameters should be:
            | one   | foo |
            | two   | bar |
            | three | 10  |

    Scenario: Request with parameters
        When I make a "POST" request to "/users" with the parameters:
            | one   | foo |
            | two   | bar |
        Then the response parameters should be:
            | one   | foo |
            | two   | bar |

    Scenario: Deep Parameters
        When I add the request parameter "one.two" with "foo"
        And I make a "POST" request to "/users"
        Then the response parameter "one.two" should exist
        And the response parameter "one.two" should be "foo"

    Scenario: Content
        When I set the request content:
           """
           {"one":"foo","two":"bar"}
           """
        And I make a "POST" request to "/users"
        Then the response content should be:
            """
            {"one":"foo","two":"bar"}
            """
        And the response content should match "/foo/"
        And the response content should not match "/ups/"

    Scenario: Print last response
        When I make a "POST" request to "/users"
        Then print last response
