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

use Lib\Request\RequestUtils,
	Lib\Request\RequestSecurity;

class Router implements RoutingInterface{
	
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
	public function __construct($request,$response,$config){
		$this->processVariables($request,$response,$config);
	}
	
	/**
	 * Variable procession
	 * 
	 * @param Request $request
	 * @param Response $response
	 * @param StdClass $config
	 */
	public function processVariables($request,$response,$config){
		$this->request = $request;
		$this->response = $response;
		$this->config = $config;
	}
	
	public function route(){
		
	}
	public function reverseRoute(){
		
	}
	public function callController(){
		
	}
	public function returnResponse(){
		
	}
}