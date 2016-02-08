<?php
	function getJsonFromFile($filename) {
		try {
			$json = file_get_contents('/var/www/my.work/'.$filename);
			return json_decode($json);
		} catch (Exception $e) {
			
		}
	}

	function setJsonToFile($filename, $json) {
		return	file_put_contents('/var/www/my.work/'.$filename, json_encode($json));
	}
?>