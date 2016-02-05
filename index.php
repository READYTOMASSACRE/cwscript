<?php 
	include 'chat.php';
	include 'search.php';
	include 'utils.php';
	include 'users.php';
	if(!session_id()) session_start();

	//dropUsersBySession(0);
	if(isset($_REQUEST['register'])) {
		echo addUser();
	}

	if(isset($_REQUEST['send'])) {
		echo chatHandler('send', $_POST['message']);
	}

	if(isset($_REQUEST['search'])) {
		echo searchHandler('search');
	}

	if(isset($_REQUEST['update'])) {
		if($_REQUEST['update'] == 'chat')
			echo chatHandler('update');
		else echo searchHandler('update');
	}

	function searchHandler($key) {
		$result = null;
		switch ($key) {
			case 'search':
				addInSearch();
				$result = searchHandler('update');
				break;
			case 'update':
				$users = getJsonFromFile('tmp/active_users.json');
				foreach($users as $id => $u) {
					if(isset($u->link)) {
						addChat(array($id, $u->link));	
						dropFromSearch($users, array($id, $u->link));
					}
				}
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
				$var = getChatHistory($_SESSION['user']);
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
?>
