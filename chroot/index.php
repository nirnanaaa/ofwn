<?php

require_once dirname(__DIR__).'/app/boot.php';

$config = dirname(__DIR__). '/app/config/app.yml';

$boot = new \core\boot();

/**
 * If you want to disable directory checks(for speed increase) just leave ->check() out!
 */
$start = microtime(true);
date_default_timezone_set('Europe/Berlin');
$boot->bootstrap($config)
	->check()
	->boot();
$end = microtime(true);
echo $end-$start;