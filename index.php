<?php 
	if(!session_id()) session_start();
	include 'chat.php';
	include 'search.php';
	include 'utils.php';

	if(isset($_REQUEST['send'])) {
		$_SESSION['user'] = 'guest_1';

		echo chatHandler('send', $_REQUEST['message']);
	}
	function searchHandler($key) {
		switch ($key) {
			case 'search':
				search();
				break;
			case 'find':
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
	}

	function chatHandler($key, $param) {
		$var = null;
		switch ($key) {
			case 'show':	
				$chats = getJsonFromFile('tmp/chat.json');
				$username = getUsername();
				getChat($chats, $username);
				break;
			case 'send':
				//$username = getUsername();
				$var = sendChat($_SESSION['user'], $param);			
				break;
			case 'update':
				break;
			default:
				break;
		}
		return $var;
	}
?>
