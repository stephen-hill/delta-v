<?php

namespace StephenHill\DeltaV
{
	$pattern = realpath(__DIR__) . '/upload/*.[mM][pP]3';
	$music = realpath(__DIR__) . '/music';

	$files = glob($pattern, GLOB_NOSORT);


	foreach ($files as $file)
	{
		$hash = hash_file('sha256', $file);
		$new = $music . '/' . $hash;
		if (file_exists($new))
		{
			echo "exists\n";
		}
		else
		{
			copy($file, $new);
			echo 'created';
		}
		
	}
}