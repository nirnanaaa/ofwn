<?php

/*
 * This file is part of the Ofwn package.
 * (c) Florian Kasper <florian.kasper@khnetworks.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 */

namespace Lib\Event\Dispatcher;

use Symfony\Component\EventDispatcher\Event,
 	Symfony\Component\HttpFoundation\Request,
 	Symfony\Component\HttpFoundation\Response;

class Router extends Event{
	
	public function getRequest(){
		return Request::createFromGlobals();
	}
	public function getResponse(){
		return new Response();
	}
	public function getRouter(){
		
	}
	
}