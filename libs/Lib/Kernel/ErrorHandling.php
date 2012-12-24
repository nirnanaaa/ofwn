<?php

/*
 * This file is part of the Ofwn package.
 * (c) Florian Kasper <florian.kasper@khnetworks.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 * 
 */

namespace Lib\Kernel;

use Symfony\Component\HttpFoundation\Response,
	Lib\Event\Dispatcher\ControllerCompleteDispatcher;

class ErrorHandling{
	
	/**
	 * @var DependencyInjection
	 */
	public $dep_injection;
	
	
	/**
	 * @var \StdClass
	 */
	public $config;
	
	/**
	 * @var \Symfony\Component\EventDispatcher\EventDispatcher
	 */
	public $dispatcher;
	
	/**
	 * Error Message status
	 * @var boolean
	 */
	public $message;
	
	/**
	 * Constructor.
	 * 
	 */
	public function __construct($dispatcher, \StdClass $config, $dep_injection){
		
		$this->dispatcher = $dispatcher;
		$this->config = $config;
		$this->dep_injection = $dep_injection;
	//	$this->setErrorPhpParamsForEnv();
		
	}
	
	public function catchError(){
		if(!error_get_last()){
			return;
		}
		if($this->message == false){
			$log = $this->dep_injection->get('log');
			$log->addWarning(error_get_last());
			$this->renderErrorTemplate(error_get_last());
			$this->message = true;
		}
		exit(1);
		
	}
	
	public function setErrorPhpParamsForEnv(){
		//register_shutdown_function(array($this,'catchError'));
		//set_error_handler(array($this,'catchError'));
		//turn off error reporting
		error_reporting(0);
		//disable displaying errors
		ini_set('display_errors', 'Off');
		//disable the fancy html errors
		ini_set('html_errors', 'Off');
	}
	public function renderErrorTemplate($message,$status = 500){
		$response = new Response();
		$twig = $this->dep_injection->get('twigerror');
		$response->setStatusCode($status)
			->setContent($twig->render($status.'.html.twig',array("error" => array(
					"title" => "ERROR",
					"type" => $message['type'],
					"file" => $message['file'],
					"line" => $message['line'],
					"message" => $message['message'],
					"statuscode" => $status
					))));
		$controller = new ControllerCompleteDispatcher($response);
		$this->dispatcher->dispatch('controller.parsed',$controller);
	}
	
}