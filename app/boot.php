<?php

/*
 * This file is part of the Ofwn package.
 * (c) Florian Kasper <florian.kasper@khnetworks.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 */
namespace core;

$vendor_dir = dirname(__DIR__)  . DIRECTORY_SEPARATOR . 'vendor';
$config = dirname(__DIR__). '/app/config/app.yml';

require $vendor_dir . DIRECTORY_SEPARATOR .'autoload.php';

$boot = new boot();
$boot->bootstrap($config)
    ->check()
    ->boot();

/**
 * Bootstrap class
 *
 * @author Florian Kasper <florian.kasper@corscience.de>
 */
class boot
{
    public function bootstrap($config)
    {
    	
    	//$ff = new \Lib\File\Resource($config);
    	$config = new \Lib\Config\YamlParser(new \Lib\File\Resource($config));
        $register = new \Lib\Kernel\RegisterKernel($config->parse());
        
        $dependencyInjection = $register->getDI();

        return $this;
    }
    public function check()
    {
        return $this;
    }
    public function boot()
    {
        return $this;
    }
}
namespace config;
class kernel
{
}
namespace checks;
class health
{
    public function isStructured()
    {
    }
    public function isSatisfied()
    {
    }
    public function isHealthy()
    {
    }
    public function isBootstrapped()
    {
    }
}
class directorys
{
    public static function cacheExists()
    {
    }
    public static function cacheEmpty()
    {
    }
    public static function cacheWritable()
    {
    }
    public static function cacheIncomplete()
    {
    }
    public static function cacheReady()
    {
    }
    public static function chrootExists()
    {
    }
    public static function chrootWritable()
    {
    }
    public static function assetsBuilt()
    {
    }
    public function checkApplication()
    {
    }
}
