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

use Assetic\Asset\AssetCollection,
    Assetic\Asset\FileAsset,
    Assetic\Asset\GlobAsset,
	Assetic\Filter\Sass\SassFilter,
	Assetic\Filter\Yui;

use Lib\Event\Dispatcher\Router;

class RegisterKernel
{
	public $config;
	public function __construct($configuration){
		$this->config = $configuration;
	}
    public function getDI()
    {
        $sc = new ContainerBuilder();
        $loader = new YamlFileLoader($sc, new FileLocator($this->config->services->directory));
        $loader->load($this->config->services->file);
        $dispatcher = new EventDispatcher();
        $router = new Router();
        $dispatcher->dispatch('kernel.event',$router);
        
		//return ::fromGlobals();
    }
    

}
