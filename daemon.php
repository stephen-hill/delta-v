<?php

namespace StephenHill\DeltaV
{
	require_once('autoloader.php');
	$database = new Database();
	
	// Set 1: Hash and move the uploaded files. Insert them into the database.
	$pattern = realpath(__DIR__) . '/upload/*.[mM][pP]3';
	$music = realpath(__DIR__) . '/music';
	$files = glob($pattern, GLOB_NOSORT);

	foreach ($files as $file)
	{
		$hash = hash_file('sha256', $file);
		$new = $music . '/' . $hash;
		
		if (file_exists($new))
		{
			echo "skipping\n";
			unlink($file);
			continue;
		}
		
		rename($file, $new);
		echo "created\n";
		
		echo $hash . PHP_EOL;
		
		$object = array
		(
			'id' => $hash,
			'filename' => basename($file)
		);
		
		$database->Add('files', $object);
	}
}