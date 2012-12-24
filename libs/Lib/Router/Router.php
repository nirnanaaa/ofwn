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
     * Injector
     */
    private $injector;
    
    /**
     * Constructor.
     *
     * @param Request  $request
     * @param Response $response
     * @param StdClass $config
     */
    public function __construct($dispatcher,$request,$response,$config,$dependencyInjector)
    {
        $this->processVariables($dispatcher,$request,$response,$config,$dependencyInjector);
    }

    /**
     * Variable procession
     *
     * @param Request  $request
     * @param Response $response
     * @param StdClass $config
     */
    public function processVariables($dispatcher,$request,$response,$config,$dependencyInjector)
    {
        $this->dispatcher = $dispatcher;
        $this->request = $request;
        $this->response = $response;
        $this->config = $config;
        $this->injector = $dependencyInjector;
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

            $route->match = preg_replace("#\{\w+\}#i","(\w+|\_|\_+|\-|\-+|\+|\++|\%|\%+)",$route->match);

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

    

    public function returnResponse(Response $response)
    {
        $response->send();
    }
}
