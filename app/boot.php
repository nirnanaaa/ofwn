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


require $vendor_dir . DIRECTORY_SEPARATOR .'autoload.php';



/**
 * Bootstrap class
 *
 * @author Florian Kasper <florian.kasper@corscience.de>
 */
class boot
{
	public $config;
	
    public function bootstrap($config)
    {
    	
    	$config = new \Lib\Config\YamlParser(new \Lib\File\Resource($config));
    	$this->config = $config->parse();
        $register = new \Lib\Kernel\RegisterKernel($this->config);
        
        $dependencyInjection = $register->getDI();

        return $this;
    }
    public function check()
    {
    	
    	$checks = new \checks\directorys();
    	$dir = $this->config->cache->directory;
    	if(!$checks->cacheExists($dir)){
    		
    	}
    	if(!$checks->cacheEmpty($dir)){
    		
    	}
    	if(!$checks->cacheWritable($dir)){
    		
    	}
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
	/**
	 * 
	 * @param string $cache
	 * @return boolean
	 */
    public static function cacheExists($cache)
    {
    	if(is_dir($cache)){
    		return true;
    	}
    	return false;
    }
    public static function cacheEmpty($path)
    {
    	$empty = true;
    	$dir = opendir($path);
    	while($file = readdir($dir))
    	{
    		if($file != '.' && $file != '..')
    		{
    			$empty = false;
    			break;
    		}
    	}
    	closedir($dir);
    	return $empty;
    }
    public static function cacheWritable($dir)
    {
    	if(is_writable($dir)){
    		return true;
    	}
    	return false;
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
