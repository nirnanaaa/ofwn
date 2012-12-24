<?php

/*
 * This file is part of the Ofwn package.
 * (c) Florian Kasper <florian.kasper@khnetworks.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 */
namespace  Lib\Kernel;

use Symfony\Component\DependencyInjection\ContainerBuilder,
    Symfony\Component\Config\FileLocator,
    Symfony\Component\DependencyInjection\Loader\YamlFileLoader,
    Symfony\Component\EventDispatcher\EventDispatcher;

use Lib\Event\Dispatcher\Router as EvRouter,
    Lib\Event\Subscriber\Router as SuRouter,
    Lib\DependencyInjection\RegisterParameters;

class RegisterKernel
{
    public $config;
    
    public $root;
    
    public function __construct($configuration,$root)
    {
        $this->config = $configuration;
        $this->root = $root;
    }
    public function getDI()
    {
    	$sc = new ContainerBuilder();
    	$par = new RegisterParameters($sc);
    	$par->registerConfigParameters($this->config);
    	$sc->setParameter('kernel.root', $this->root);
    	$loader = new YamlFileLoader($sc, new FileLocator($this->config->services->directory));
    	$loader->load($this->config->services->file);
    	$dispatcher = new EventDispatcher();
    	
    	$globalSubscriber = new SuRouter();
    	$dispatcher->addSubscriber($globalSubscriber);
    	
    	$errorHandler = new ErrorHandling($dispatcher, $this->config, $sc);
    	try{
        	$router = new EvRouter($this->config);
        	$dispatcher->dispatch('kernel.event',$router);
        }catch(\Exception $e){
        	trigger_error($e->getMessage(),E_CORE_ERROR);
        }
        
        //return ::fromGlobals();
    }

}
