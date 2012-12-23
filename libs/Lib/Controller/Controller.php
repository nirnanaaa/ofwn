<?php

/*
 * This file is part of the Ofwn package.
 * (c) Florian Kasper <florian.kasper@khnetworks.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 * 
 */

namespace Lib\Controller;

use Symfony\Component\HttpFoundation\Response,
	Symfony\Component\HttpFoundation\Request;

class Controller{
	
	/**
	 * The Response.
	 * 
	 * @var \Symfony\Component\HttpFoundation\Response
	 */
	private $response;
	
	/**
	 * The Request.
	 * 
	 * @var \Symfony\Component\HttpFoundation\Request
	 */
	private $request;
	
	/**
	 * Constructor.
	 * 
	 * @param \Symfony\Component\HttpFoundation\Response $response
	 * @param \Symfony\Component\HttpFoundation\Request $request
 	 */
	public function __construct(Response $response, Request $request){
		$this->response = $response;
		$this->request = $request;
	}
	
	/**
	 * gets the request
	 * 
	 * @return \Symfony\Component\HttpFoundation\Request
	 */
	public function getRequest(){
		return $this->request;
	}
	
	/**
	 * gets the current response
	 * 
	 * @return \Symfony\Component\HttpFoundation\Response
	 */
	public function getResponse(){
		return $this->response;
	}
	
	/**
	 * renders raw text as text/plain mime
	 * 
	 * @param string $text
	 * @return \Symfony\Component\HttpFoundation\Response
	 */
	public function renderText($text){
		if(is_string($text)){
			$this->response->setContent($text)
			->setStatusCode(200);
		}
		
		
		return $this->response;
	}
	
	public function render(){
		
	}
	
	public function renderView(){
		
	}
}