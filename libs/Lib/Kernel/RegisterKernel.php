<?php
namespace  Lib\Kernel;

use Symfony\Component\DependencyInjection\ContainerBuilder;

class RegisterKernel
{
    public function getDI()
    {
        $sc = new ContainerBuilder();
        $sc->register('log.writer','\\Monolog\\Logger')
        ->addArgument('name');
        $request = new \Lib\Request\Request();
        echo $request->addLeadingSlash("abc");

    }

}
