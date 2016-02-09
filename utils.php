<?php
	function getJsonFromFile($filename) {
		try {
			$path = '/var/hosting/work.local/www/tmp/';
			$json = file_get_contents($path.$filename);
			return json_decode($json);
		} catch (Exception $e) {
			
		}
	}

	function setJsonToFile($filename, $json) {
		$path = '/var/hosting/work.local/www/tmp/';
		return	file_put_contents($path.$filename, json_encode($json));
	}
?>