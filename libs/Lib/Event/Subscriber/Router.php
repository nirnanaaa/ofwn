<?php

/*
 * This file is part of the Ofwn package.
 * (c) Florian Kasper <florian.kasper@khnetworks.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 */

namespace Lib\Event\Subscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface,
 	Symfony\Component\HttpKernel\Event\FilterResponseEvent,
 	Symfony\Component\EventDispatcher\Event;

use Lib\Router\RouterEventReceiver,
	Lib\Router\Exception\NotFoundException;

class Router implements EventSubscriberInterface{
	
	protected $router;
	
	static public function getSubscribedEvents()
	{
		return array(
				'kernel.event' => array(
						array('onKernelResponsePre', 10),
						array('onRouterChecksPassed', 5)
						),
				'route.found' => array('onRouteFound',0),
				'route.notfound' => array('onRouteNotFound',0),
				'controller.parsed' => array('onControllerParsed',0),
				//'router.checks.passed' => array('onRouterChecksPassed',0)
		);
	}
	
	public function onKernelResponsePre(Event $event)
	{
		$router = new \Lib\Router\RouterEventReceiver();
		$router->processKernelEvent($event);
	}
	
	public function onRouterChecksPassed(Event $event){
		$this->router = new \Lib\Router\Router($event->getDispatcher(),
				$event->getRequest(),
				$event->getResponse(),
				$event->getConfig());
		$this->router->process();
	}
	
	public function onRouteFound(Event $event){
		$this->router->callController($event->getFullObject(),$event->getMatch());
	}
	
	public function onRouteNotFound(Event $event){
		throw new NotFoundException("the given route was not found");
	}
	
	public function onControllerParsed(Event $event){
		$this->router->returnResponse($event->getResponse());
	}
	
}