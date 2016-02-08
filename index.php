<?php 
	include 'chat.php';
	include 'search.php';
	include 'utils.php';
	include 'users.php';
	
	if(!session_id()) session_start();

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
?>
