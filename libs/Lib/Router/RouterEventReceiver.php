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

use Symfony\Component\EventDispatcher\Event,
	Symfony\Component\EventDispatcher\EventDispatcher,
	Symfony\Component\HttpFoundation\Request,
	Symfony\Component\HttpFoundation\Response;

use Lib\Router\Exception\InstanceException;

class RouterEventReceiver{
	/**
	 * The Event Dispatcher
	 * @var \Symfony\Component\EventDispatcher\EventDispatcher
	 */
	protected $dispatcher;
	
	/**
	 * The Request Oject from globals
	 * @var \Symfony\Component\HttpFoundation\Request
	 */
	protected $request;
	
	/**
	 * A new Response Oject
	 * @var \Symfony\Component\HttpFoundation\Response
	 */
	protected $response;
	
	
	/**
	 * processes the event, checks for right instances and calls the router procession
	 * 
	 * @param \Symfony\Component\EventDispatcher\Event $event
	 * @throws InstanceException
	 */
	public function processKernelEvent(Event $event){
		if(!$event->getDispatcher() instanceof EventDispatcher){
			throw new InstanceException("Dispatcher is not an instance of \Symfony\Component\EventDispatcher\EventDispatcher");
		}
		$this->dispatcher = $event->getDispatcher();
		if(!$event->getResponse() instanceof Response){
			throw new InstanceException("Response is not an instance of \Symfony\Component\HttpFoundation\Response");
		}
		$this->response = $event->getResponse();
		if(!$event->getRequest() instanceof Request){
			throw new InstanceException("Request is not an instance of \Symfony\Component\HttpFoundation\Request");
		}
		$this->request = $event->getRequest();
		
	}
	
}