<?php

/*
 * This file is part of the Ofwn package.
 * (c) Florian Kasper <florian.kasper@khnetworks.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 */

namespace Lib\Router;

use Symfony\Component\HttpFoundation\Response;

use Lib\Request\RequestSecurity,
    Lib\Router\RouterUtils,
    Lib\Router\RouteParser,
    Lib\File\Resource as FileResource,
    Lib\Router\Exception\NotFoundException,
    Lib\Event\Dispatcher\RouteFoundDispatcher,
    Lib\Event\Dispatcher\ControllerCompleteDispatcher;

class Router implements RoutingInterface
{
    /**
     * Event Dispatcher
     * @var EventDispatcher
     */
    private $dispatcher;

    /**
     * Symfony's Request object (already checked)
     * @var Request
     */
    private $request;

    /**
     * Symfony's Response object (already checked)
     * @var Response
     */
    private $response;

    /**
     * The configuration
     * @var StdClass
     */
    private $config;

    /**
     * The current URL
     */
    private $url;

    /**
     * Constructor.
     *
     * @param Request  $request
     * @param Response $response
     * @param StdClass $config
     */
    public function __construct($dispatcher,$request,$response,$config)
    {
        $this->processVariables($dispatcher,$request,$response,$config);
    }

    /**
     * Variable procession
     *
     * @param Request  $request
     * @param Response $response
     * @param StdClass $config
     */
    public function processVariables($dispatcher,$request,$response,$config)
    {
        $this->dispatcher = $dispatcher;
        $this->request = $request;
        $this->response = $response;
        $this->config = $config;
    }

    /**
     * main routing function. Manages the routing
     *
     * /bla/bla/bla to /src/Core/Controller/AbcController.php
     *
     * @see \Lib\Router\RoutingInterface::route()
     */
    public function route()
    {
        $utils = new RouterUtils("/");
        $parser = new RouteParser(new FileResource($this->config->router->global_router));
        $parsed = $parser->parse();
        $found = false;
        $result = new \stdClass();
        foreach ($parsed as $name => $route) {
            $this->url = $utils->cutWebRoot(
                        $utils->getRequestPath(
                                $this->request->getRequestUri()
                        ),
                        $this->config->web->root
                    );

            $route->match = preg_replace("#\{\w+\}#i","(\w+|\_\-\+\%)",$route->match);

            if (preg_match("#^{$route->match}$#",$this->url)) {
                if (in_array($this->request->getMethod(),(array) $route->via)) {
                    $routeFoundDispatcher = new RouteFoundDispatcher($name,$route);
                    $this->dispatcher->dispatch("route.found",$routeFoundDispatcher);
                    $found = true;
                    break;
                }
            }
        }
        if ($found === false) {
            $this->dispatcher->dispatch("route.notfound");
        }
    }

    /**
     * The same as route() but solves AbcController.php to /bla/bla/bla
     *
     * @see \Lib\Router\RoutingInterface::reverseRoute()
     */
    public function reverseRoute()
    {
        //print_r();
    }

    /**
     * processes the request
     *
     */
    public function process()
    {
        $utils = new RouterUtils("/");
        if((strpos($utils->cutWebRoot($utils->getRequestPath($this->request->getRequestUri()),$this->config->web->root),
                ".".$this->config->general->phpext) === false) && $this->request->get('format') !== $this->config->general->phpext){
             $this->route();
        } else {
             $this->reverseRoute();
        }

    }

    /**
     * calls specified controller, using a Reflector method call
     *
     * @param string $object
     * @param string $match
     * @see \Lib\Router\RoutingInterface::callController()
     */
    public function callController($object,$match)
    {
        $call = explode(":",$object);
        if (empty($call[0])) {
            throw new NotFoundException("The controller class string was empty");
        }
        if (empty($call[2])) {
            $call[2] = 'index';
        }
        list($controller,$params,$method) = $call;
        if (!class_exists($controller)) {
            throw new NotFoundException("The controller class was not found on the system");
        }
        $parent = "Lib\\Controller\\Controller";
        if (!is_subclass_of($controller, $parent)) {
            throw new NotFoundException(sprintf("The controller %s is not a subclass of %s",$controller,$parent));
        }
        $method = "{$method}Action";
        if (!method_exists($controller, $method)) {
            throw new NotFoundException(sprintf("The method %s was not found in class %s",$method,$controller));
        }
        $class = new $controller($this->response,$this->request,$this->config);
        $reflector = new \ReflectionMethod($class, $method);
        $reflector_params = $reflector->getParameters();
        ob_start();
        
        if (count($reflector_params) >= 1) {
             preg_match_all("#/\\w+#", $match,$matches);
            $matches = str_replace(implode($matches[0]),"",$this->url);
            if (strpos($matches,"/") === 0) {
                $matches[0] = "";
            }
            $matches = explode("/",$matches);
            $argumentBuilder = array();
            foreach ($reflector_params as $parameters) {
                $argumentBuilder[] = $parameters->getPosition();
            }
            $arguments = array_combine($argumentBuilder, $matches);
            $call = $reflector->invokeArgs($class, $arguments);
            ob_end_clean();
        } else {

            $call = $reflector->invoke($class, NULL);
        }

        //print_r($call);
        if (null === $call) {
            throw new NotFoundException(sprintf("The method %s must return a valid response!",$method));
            //exception no return call;
        }
        $cntrl = new ControllerCompleteDispatcher($call);
        $this->dispatcher->dispatch('controller.parsed',$cntrl);
    }

    public function returnResponse(Response $response)
    {
        $response->send();
    }
}
