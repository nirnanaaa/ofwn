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
	Lib\File\Resource as FileResource;
	
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
		print_r($parsed);
		$found = false;
		$result = new \stdClass();
		foreach($parsed as $name => $route){
			if($utils->cutWebRoot($utils->getRequestPath($this->request->getRequestUri()),$this->config->web->root) === $route->match){
				if(in_array($this->request->getMethod(),(array) $route->via)){
					$result->name = $name;
					$result->to = $route->to;
					$found = true;
					break;
				}
			}
		}
		if($found === false){
			echo "no route found!";//EXCE
			exit(1);
		}
		return $result;
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
			$route = $this->route();
		}else{
			$route = $this->reverseRoute();
		}
		$this->callController($route);
		
	}
	
	/**
	 * calls specified controller
	 * @see \Lib\Router\RoutingInterface::callController()
	 */
	public function callController($object){
		$call = explode(":",$object->to);
		if(empty($call[0])){
			//EXCEPTION Controller not set
		}
		if(empty($call[2])){
			$call[2] = 'index';
		}
		list($controller,$params,$method) = $call;
		if(!class_exists($controller)){
			//Exception controller not found
		}
		$method = "{$method}Action";
		if(!method_exists($controller, $method)){
			//Exception method not found
		}
		$static = false;
		if(!empty($params)){
			if(strpos($params,"static") !== false){
				$static = true;
			}
		}
		
	}
	
	public function returnResponse(){
		
	}
}