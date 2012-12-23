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

use Lib\Request\RequestSecurity,
	Lib\Router\RouterUtils,
	Lib\Router\RouteParser,
	Lib\File\Resource as FileResource,
	Lib\Router\Exception\NotFoundException,
	Lib\Event\Dispatcher\RouteFoundDispatcher;
	
class Router implements RoutingInterface{
	
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
	 * Constructor.
	 * 
	 * @param Request $request
	 * @param Response $response
	 * @param StdClass $config
	 */
	public function __construct($dispatcher,$request,$response,$config){
		$this->processVariables($dispatcher,$request,$response,$config);
	}
	
	/**
	 * Variable procession
	 * 
	 * @param Request $request
	 * @param Response $response
	 * @param StdClass $config
	 */
	public function processVariables($dispatcher,$request,$response,$config){
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
	public function route(){
		$utils = new RouterUtils("/");
		$parser = new RouteParser(new FileResource($this->config->router->global_router));
		$parsed = $parser->parse();
		echo "<pre>";
		$found = false;
		$result = new \stdClass();
		foreach($parsed as $name => $route){
			$rUrl = $utils->cutWebRoot(
						$utils->getRequestPath(
								$this->request->getRequestUri()
						),
						$this->config->web->root
					);
			
			if(preg_match("#^{$route->match}$#",$rUrl)){				
				if(in_array($this->request->getMethod(),(array) $route->via)){
					$routeFoundDispatcher = new RouteFoundDispatcher($name,$route);
					$this->dispatcher->dispatch("route.found",$routeFoundDispatcher);
					$found = true;
					break;
				}
			}
		}
		if($found === false){
			$this->dispatcher->dispatch("route.notfound");
		}
	}
	
	/**
	 * The same as route() but solves AbcController.php to /bla/bla/bla
	 * 
	 * @see \Lib\Router\RoutingInterface::reverseRoute()
	 */
	public function reverseRoute(){
		//print_r();
	}
	
	/**
	 * processes the request
	 * 
	 */
	public function process(){
		$utils = new RouterUtils("/");
		if((strpos($utils->cutWebRoot($utils->getRequestPath($this->request->getRequestUri()),$this->config->web->root),
				".".$this->config->general->phpext) === false) && $this->request->get('format') !== $this->config->general->phpext){
			 $this->route();
		}else{
			 $this->reverseRoute();
		}
		
	}
	
	/**
	 * calls specified controller
	 * @see \Lib\Router\RoutingInterface::callController()
	 */
	public function callController($object){
		$call = explode(":",$object);
		if(empty($call[0])){
			throw new NotFoundException("The controller class wstring was empty");
		}
		if(empty($call[2])){
			$call[2] = 'index';
		}
		list($controller,$params,$method) = $call;
		if(!class_exists($controller)){
			throw new NotFoundException("The controller class was not found on the system");
		}
		$parent = "Lib\\Controller\\Controller";
		if(!is_subclass_of($controller, $parent)){
			throw new NotFoundException(sprintf("The controller %s is not a subclass of %s",$controller,$parent));
		}
		$method = "{$method}Action";
		if(!method_exists($controller, $method)){
			throw new NotFoundException(sprintf("The method %s was not found in class %s",$method,$controller));
		}
		
		$class = new $controller;
		$class->$method("123");
		
	}
	
	public function returnResponse(){
		
	}
}