<?php

// PSR-0
spl_autoload_register(function($class)
{
	$directories = array(
		dirname(__FILE__) . DIRECTORY_SEPARATOR . "models"
	);
	
	$path = $class . ".php";
	$path = str_replace("\\", DIRECTORY_SEPARATOR, $path);
	$path = str_replace("_", DIRECTORY_SEPARATOR, $path);
	
	foreach ($directories as $dir)
	{
		$fullpath = $dir . DIRECTORY_SEPARATOR . $path;
				
		if (stream_resolve_include_path($fullpath) !== false)
		{
			require_once($fullpath);
		}
	}
});

// ID3
spl_autoload_register(function($class)
{
	$directories = array(
		dirname(__FILE__) . DIRECTORY_SEPARATOR . 'models' . DIRECTORY_SEPARATOR . 'getid3'
	);
	
	$path = $class . '.php';
	$path = str_replace('_', '.', $path);
	$path = strtolower($path);
	
	foreach ($directories as $dir)
	{
		$fullpath = $dir . DIRECTORY_SEPARATOR . $path;
				
		if (stream_resolve_include_path($fullpath) !== false)
		{
			require_once($fullpath);
			
		}
	}
});