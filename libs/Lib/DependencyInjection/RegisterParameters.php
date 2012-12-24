<?php

/*
 * This file is part of the Ofwn package.
 * (c) Florian Kasper <florian.kasper@khnetworks.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 */

namespace Lib\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;


class RegisterParameters{
	
	/**
	 * Dependency Injector
	 * @var \Symfony\Component\DependencyInjection\ContainerBuilder 
	 */
	private $injector;
	
	/**
	 * Pointer
	 */
	private $pointer;
		
	/**
	 * Constructor.
	 * 
	 * @param ContainerBuilder $injector
	 */
	public function __construct(ContainerBuilder $injector){
		$this->injector = $injector;
	}
	public function registerConfigParameters($segment){
		foreach($segment as $name => $segmented){

			if($segmented instanceof \StdClass){
				$this->pointer = $name;
				$this->registerConfigParameters($segmented);

			}else{
				$this->injector->setParameter($this->pointer.".".$name, $segmented);
				
				
			}
		}
	}
	
}