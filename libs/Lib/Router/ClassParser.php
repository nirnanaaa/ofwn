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

use Lib\Cache\Cache;

use Lib\Router\Exception\NotFoundException;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class ClassParser{
	
	/**
	 * e.g. Class\Is\Controller\BlaController::index
	 * @var string
	 */
	public $classString;
	
	/**
	 * PCRE like Regex
	 * @var string
	 */
	private $match;
	
	/**
	 * Dependency injector
	 * @var ContainerBuilder
	 */
	private $injector;
	
	/**
	 * call pieces
	 * @var array
	 */
	private $pieces = array();
	/**
	 * parent class
	 */
	private $parent = 'Lib\Controller\Controller';
	/**
	 * Constructor.
	 * 
	 * @param string $cntrlString
	 * @param string $match
	 * @param ContainerBuilder $dependencyInjector
	 */
	public function __construct($cntrlString, $match, ContainerBuilder $dependencyInjector){
		$this->classString = $cntrlString;
		$this->match = $match;
		$this->injector = $dependencyInjector;
	}
	
	/**
	 * Process function
	 * 
	 */
	public function process(){
		list($this->pieces['controller'],
			$this->pieces['options'],
			$this->pieces['method']
			) = explode(":",$this->classString);
		
		if(true !== ($error = $this->checkController())){
			throw new NotFoundException(sprintf("%s",$error));
		}
		$reflec = $this->getReflectionClass();
		$instance = $this->getObject();
		$reflem = $this->getReflectionMethod($reflec);
		$params = $reflem->getParameters();
		$utils = new RouterUtils();
		$request = $this->injector->get('request');
		$url = $utils->cutWebRoot(
				$utils->getRequestPath(
						$request->getRequestUri()
				),
				$this->injector->getParameter('web.root')
		);
		
		if(count($params)==0){
			$call = $reflem->invoke($instance, NULL);
		}else{
			preg_match_all("#/\\w+#", $this->match,$matches);
			
			$matches = str_replace(implode($matches[0]),"",$url);
			if (strpos($matches,"/") === 0) {
				$matches[0] = "";
			}
			print_r($matches);
		}
		//print_r($reflem->getParameters());
		//if(null === ($cache = $this->getCacheClass())){
		//}
		
	}
	
	/**
	 * NYI
	 * @return number
	 */
	public function getCacheClass(){
		$classname = $this->getReflectionClass()->getFileName();
		$cache = new Cache('class', $this->injector);
		if(null === $cache->readCache('classcache')){
			$cache->writeCache('classcache',"");
			
			
		}
		return 1;
	}
	
	/**
	 * chechs controller integrity
	 * 
	 * @return boolean|string
	 */
	public function checkController(){
		if(empty($this->pieces['controller'])){
			return "The controller class string was empty";
		}
		if(empty($this->pieces['method'])){
			$this->pieces['method'] = 'index';
		}
		if(!class_exists($this->pieces['controller'])){
			return "the controller class was not found!";
		}
		if(!is_subclass_of($this->pieces['controller'],$this->parent)){
			return sprintf("the controller %s must extend class %s",
					$this->pieces['controller'],$this->parent);
		}
		if(strpos($this->pieces['method'],'Action') === false){
			$this->pieces['method'] .= 'Action';
		}
		if(!method_exists($this->pieces['controller'],$this->pieces['method'])){
			return sprintf("the given method %s was not found in class %s",
					$this->pieces['method'],$this->pieces['controller']);
		}
		return true;
	}
	
	/**
	 * checks the method for valid parameter handling
	 * 
	 * @return boolean|string
	 */
	public function checkMethod(){
		
	}
	
	/**
	 * Gets a new Controller class Object
	 * @return Object
	 */
	public function getObject(){
		return new $this->pieces['controller'](
				$this->injector->get('Response'),
				$this->injector->get('Request'),
				$this->injector
				);
	}
	
	/**
	 * gets the reflecion class
	 * 
	 * @return \ReflectionClass
	 */
	public function getReflectionClass(){
		return new \ReflectionClass($this->pieces['controller']);
	}
	
	/**
	 * gets the reflection method
	 */
	public function getReflectionMethod(\ReflectionClass $reflectionClass){
		return $reflectionClass->getMethod($this->pieces['method']);
	}
	
	/**
	 * calls specified controller, using a Reflector method call
	 *
	 * @see \Lib\Router\RoutingInterface::callController()
	 */
	public function callController()
	{
		$class = new $controller($this->response,$this->request,$this->config,$this->injector);
		$reflector = new \ReflectionMethod($class, $method);
		$reflector_params = $reflector->getParameters();
	
		if (count($reflector_params) >= 1) {
			preg_match_all("#/\\w+#", $match,$matches);
			$matches = str_replace(implode($matches[0]),"",$this->url);
			if (strpos($matches,"/") === 0) {
				$matches[0] = "";
			}
			$matches = explode("/",$matches);
			$argumentBuilder = array();
			foreach ($reflector_params as $parameters) {
				$argumentBuilder[] = $parameters->getPosition();
			}
			$arguments = array_combine($argumentBuilder, $matches);
			$call = $reflector->invokeArgs($class, $arguments);
			 
		} else {
	
			$call = $reflector->invoke($class, NULL);
		}
	
		//print_r($call);
		if (null === $call) {
			throw new NotFoundException(sprintf("The method %s must return a valid response!",$method));
			//exception no return call;
		}
		$cntrl = new ControllerCompleteDispatcher($call);
		$this->dispatcher->dispatch('controller.parsed',$cntrl);
	}
}