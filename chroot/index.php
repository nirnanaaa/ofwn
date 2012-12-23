<?php

require_once dirname(__DIR__).'/app/boot.php';

$config = dirname(__DIR__). '/app/config/app.yml';

$boot = new \core\boot();

/**
 * If you want to disable directory checks(for speed increase) just leave ->check() out!
 */
$boot->bootstrap($config)
	->check()
	->boot();