<?php
namespace App\Router;

class Router
{
    private $_request;
    private $_supportedHttpMethods = ["GET", "POST"];

    function __construct(IRequest $request)
    {
        $this->_request = $request;
    }

    function __call($name, $args)
    {
        list($route, $method) = $args;
        if(!in_array(strtoupper($name), $this->_supportedHttpMethods))
        {
            $this->invalidMethodHandler();
        }
        $this->{strtolower($name)}[$this->formatRoute($route)] = $method;
    }

    private function formatRoute($route)
    {
        $result = rtrim($route, '/');
        if($result === '')
        {
            return '/';
        }
        return $result;
    }

    private function invalidMethodHandler()
    {
        header("{$this->_request->serverProtocol} 405 Method Not Allowed");
    }

    private function defaultRequestHandler()
    {
        header("{$this->_request->serverProtocol} 404 Not Found");
    }

    function resolve()
    {
        $methodDictionary = $this->{strtolower($this->_request->requestMethod)};
        $formatedRoute = $this->formatRoute($this->_request->requestUri);
        $method = $methodDictionary[$formatedRoute];

        if(is_null($method))
        {
            $this->defaultRequestHandler();
            return;
        }

        echo call_user_func_array($method, array($this->_request));
    }

    function __destruct()
    {
        $this->resolve();
    }
}