<?php

	include 'index.php';

	while(1) {
		$result = search();
		sleep(8);
		$result = $result ? 'Search success' : 'Not users for searching. Still work..';
		writelog('['.date('Y/d/m H:i:s').'] Search executed with status: '.$result);
	}

	function writelog($string) {
		$log = file_get_contents('/var/www/my.work/tmp/log.txt');
		$log .= $string."\n";
		file_put_contents('/var/www/my.work/tmp/log.txt', $log);
	}
?>