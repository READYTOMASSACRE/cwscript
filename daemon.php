<?php

	include 'index.php';
	//if(session_id()) die();
	print("\n[SEARCH] daemon started at ".date('Y/d/m H:i:s'));

	while(1) {
		$result = search();
		$result = $result ? 'Search success' : 'Not users for searching. Still work..';
		writelog('[Daemon.php] ['.date('Y/d/m H:i:s').'] Search executed with status: '.$result);
		sleep(8);
	}

	function writelog($string) {
		$log = file_get_contents('/var/www/my.work/tmp/log.txt');
		$log .= $string."\n";
		file_put_contents('/var/www/my.work/tmp/log.txt', $log);
	}

	function search() {
		$users = getJsonFromFile('active_users.json');
		if (empty($users->count)) return false;
		foreach ($users as $id => $u) {
			if ($id[0] == 'g')
				findOpponent($users, $id);
		}

		setJsonToFile('active_users.json', $users);
		return true;
	}

	/**
	 * find opponents by finder 
	 * @param &array $users
	 * @param string $finder
	 * @return false if $finder already find opponent else true
	 *
	 */
	function findOpponent(&$users, $finder) {
		foreach ($users as $target => $value) {
			if($finder != $target && $target[0] == 'g') {
				if($users->$finder >= $value) {
					$chatId = addChat(array($finder, $target));
					dropFromSearch($users, array($finder, $target), $chatId);
					break;
				}
			}
		}
		return true;
	}
?>