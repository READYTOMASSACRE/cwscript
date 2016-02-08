<?php

	include 'index.php';

	$GLOBALS['cantSearch'] = true;

	for($i=0;$i<4;$i++) {
		echo '<br>';
		sleep(1);
		searchBool();
		var_dump($GLOBALS['cantSearch']);
	}

	function searchBool() {
		$GLOBALS['cantSearch'] = $GLOBALS['cantSearch'] ? false : true;
	}
?>