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

use Lib\Router\RouterEventReceiver;

class Router implements EventSubscriberInterface{
	static public function getSubscribedEvents()
	{
		return array(
				'kernel.event' => array('onKernelResponsePre', 10),
				'router.checks.passed' => array('onRouterChecksPassed',0)
		);
	}
	
	public function onKernelResponsePre(Event $event)
	{
		$router = new \Lib\Router\RouterEventReceiver();
		$router->processKernelEvent($event);
	}
	public function onRouterChecksPassed(Event $event){
		
	}
	
}