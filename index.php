<?php 
	include 'chat.php';
	include 'search.php';
	include 'utils.php';
	include 'users.php';
	
	if(!session_id()) session_start();

	if(isset($_REQUEST['init'])) {

		$result = new stdClass();
		$users = countOnlineUsers();
		$result->totalOnline = $users->total;
		$result->searchOnline = $users->search;
		$result->username = garbageCollector();

/*		if(isset($_SESSION['user'])) {
		


			$users = getJsonFromFile('users.json');
			if($users->$_SESSION['user']) {
				$users->$_SESSION['user']->online = true;
				$users->$_SESSION['user']->visited = time();
			}
		}

		if ($_SESSION['status'] == 2) {
			$obj = new stdClass();
			$obj->status = 2;
			$obj->username = $_SESSION['user'];
			echo json_encode($obj);
		}*/
		echo json_encode($result);
	}

	if(isset($_REQUEST['quit'])) {
		garbageCollector();
	}

	if(isset($_REQUEST['send'])) {
		echo chatHandler('send', $_POST['message']);
	}

	if(isset($_REQUEST['search'])) {
		if($_REQUEST['search'] == 'update') 
			echo searchHandler('update');
		else {
			echo searchHandler('search');
		}
	}

	if(isset($_REQUEST['update'])) {
		echo searchHandler('update');
	}

	function searchHandler($key) {
		$result = null;
		switch ($key) {
			case 'search':
				addInSearch();
				break;
			case 'update':				
				if($_SESSION['status'] == 2) $result = getChatHistory($_SESSION['chat']);
				else if ($_SESSION['status'] == 1) $result = searchResult();
			default:
				break;
		}
		return $result;
	}


	/**
	 * chat handler, keys: show, send | params: message
	 * @param string $key
	 * @param mixed $params
	 * @return mixed
	 *
	 */
	function chatHandler($key, $params) {
		$var = null;
		switch ($key) {
			case 'show':	
				$var = getChatHistory($_SESSION['chat']);
				break;
			case 'send':
				//$username = getUsername();
				$var = sendChat($_SESSION['user'], $params);	
				break;
			default:
				break;
		}
		return $var;
	}



	function garbageCollector($params) {

		if(isset($_SESSION['user'])) {
			$users = getJsonFromFile('users.json');

			if(isset($users->$_SESSION['user'])) {
				if(isset($_REQUEST['quit']))
					$users->$_SESSION['user']->online = false;
				else {
					$users->$_SESSION['user']->online = true;
					$users->$_SESSION['user']->visited = time();
				}
			} else {
				$activeUsers = getJsonFromFile('active_users.json');
				
				// old data, need update
				if($activeUsers->$_SESSION['user'] === null) {
					$_SESSION['user'] = null;
					addUser();
				} 
				/**
				 * @todo normal setup offline 
				 */
				else if(isset($_SESSION['quit'])) {
					$string = $_SESSION['user'];
					$_SESSION['user'] = null;
					dropFromSearch($activeUsers, array($string));
					setJsonToFile('active_users.json', $activeUsers);
					garbageCollector();
				}
			}
			return $_SESSION['user'];
		}
		else {
			return addUser();
		}
	}
?>
