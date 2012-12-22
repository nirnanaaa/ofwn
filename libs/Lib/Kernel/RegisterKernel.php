<?php
namespace  Lib\Kernel;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Assetic\Asset\AssetCollection,
    Assetic\Asset\FileAsset,
    Assetic\Asset\GlobAsset,
	Assetic\Filter\Sass\SassFilter,
	Assetic\Filter\Yui;
	

class RegisterKernel
{
    public function getDI()
    {
        $sc = new ContainerBuilder();
        $sc->register('log','\\Monolog\\Logger')
        ->addArgument('core');
        $sc->register('assetic', '\\Assetic\\Asset\\AssetCollection')
		->addArgument(array(
		new FileAsset(__DIR__. DIRECTORY_SEPARATOR .'..'. DIRECTORY_SEPARATOR .'..'. DIRECTORY_SEPARATOR .'assets'. DIRECTORY_SEPARATOR .'js'. DIRECTORY_SEPARATOR .'node.js')
		
		));//change
		$file = \Lib\Request\Request::fromGlobals();
		
		
		//$assetic =  "<script>".$sc->get('assetic')->dump()."</script>";
    }

}
