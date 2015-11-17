<?php defined('ABSPATH') or die;

/**
 * Register our own autoloader in the top of the stack
 */
spl_autoload_register(function($class) {

	if (strpos($class, 'VP\\') !== 0)
		return;

	$file = preg_replace('/^VP\\//i', __DIR__ . '/lib/', str_replace('\\', '/', $class)) . '.php';

	if (file_exists($file))
		require_once $file;

}, true, true);