<?php

namespace core;
$vendor_dir = dirname(__DIR__) . '..' . DIRECTORY_SEPARATOR . 'vendor';

require $vendor_dir . DIRECTORY_SEPARATOR .'autoload.php';
$boot = new boot();
$boot->bootstrap()
    ->check()
    ->boot();

class boot
{
    public function bootstrap()
    {
        $register = new \Lib\Kernel\RegisterKernel();
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
