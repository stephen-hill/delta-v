<?php

namespace StephenHill\DeltaV
{
	use \getID3;
	
	require_once('autoloader.php');
	$database = new Database();
	$getID3 = new getID3();
	$getID3->setOption(array('encoding' => 'UTF-8'));
	
	// Set 1: Hash and move the uploaded files. Insert them into the database.
	$pattern = realpath(__DIR__) . '/upload/*.[mM][pP]3';
	$music = realpath(__DIR__) . '/music';
	$files = glob($pattern, GLOB_NOSORT);

	foreach ($files as $file)
	{
		$hash = hash_file('md5', $file);
		$new = $music . '/' . $hash;
		
		if (file_exists($new))
		{
			unlink($file);
			continue;
		}
		
		$id3 = $getID3->analyze($file);
		
		$object = array
		(
			'id' => $hash,
			'filename' => basename($file),
			'bitrate' => (int)$id3['audio']['bitrate'],
			'samplerate' => (int)$id3['audio']['sample_rate'],
			'channels' => (int)$id3['audio']['channels'],
			'size' => filesize($file),
			'duration' => (int)round($id3['playtime_seconds']),
			'title' => $id3['tags']['id3v2']['title'][0],
			'artist' => $id3['tags']['id3v2']['artist'][0],
			'added' => date("Y-m-d H:i:s"),
			'contenttype' => $id3['mime_type']
		);
		
		if (array_key_exists('year', $id3['tags']['id3v2']) === true)
		{
			$object['year'] = (int)$id3['tags']['id3v2']['year'][0];
		}
		
		if (array_key_exists('track_number', $id3['tags']['id3v2']) === true)
		{
			$object['track'] = (int)$id3['tags']['id3v2']['track_number'][0];
		}
		
		if (array_key_exists('album', $id3['tags']['id3v2']) === true)
		{
			$object['album'] = $id3['tags']['id3v2']['album'][0];
		}
		
		if (array_key_exists('band', $id3['tags']['id3v2']) === true)
		{
			$object['album-arist'] = $id3['tags']['id3v2']['band'][0];
		}
		
		$database->Add('files', $object);
		rename($file, $new);
				
		var_dump($id3);
		
		var_dump($object);
	}
}