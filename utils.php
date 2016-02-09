<?php
	function getJsonFromFile($filename) {
		try {
			$path = '/var/www/my.work/tmp/';
			$json = file_get_contents($path.$filename);
			return json_decode($json);
		} catch (Exception $e) {
			
		}
	}

	function setJsonToFile($filename, $json) {
		$path = '/var/www/my.work/tmp/';
		return	file_put_contents($path.$filename, json_encode($json));
	}
?>