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
	Lib\Router\RouterUtils;
	
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
		
	}
	
	/**
	 * The same as route() but solves AbcController.php to /bla/bla/bla
	 * 
	 * @see \Lib\Router\RoutingInterface::reverseRoute()
	 */
	public function reverseRoute(){
		print_r();
	}
	
	/**
	 * processes the request
	 * 
	 */
	public function process(){
		
	}
	/**
	 * calls specified controller
	 * @see \Lib\Router\RoutingInterface::callController()
	 */
	public function callController($controller,$method = 'index'){
		
	}
	
	public function returnResponse(){
		
	}
}