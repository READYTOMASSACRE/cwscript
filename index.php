<?php 
	if(!session_id()) session_start();
	include 'chat.php';
	include 'search.php';
	include 'utils.php';

	if(isset($_REQUEST['register'])) {
		echo newUser();
	}

	if(isset($_REQUEST['send'])) {
		echo chatHandler('send', $_REQUEST['message']);
	}

	if(isset($_REQUEST['search'])) {
		searchHandler('search');
	}

	function searchHandler($key) {
		switch ($key) {
			case 'search':
				addInSearch();
				$result = search(getJsonFromFile('tmp/active_users.json'));
				echo 'You try find and got: '.$result->$_SESSION['user']->link;
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


	function newUser() {
		if (!empty($_SESSION['user']))
			return $_SESSION['user'];

		$users = getJsonFromfile('tmp/users.json');
		if ($users->lastId === null) {
			echo 'THAT IS NEW USER<br>';
			$newId = 'guest_0'; 
			$users->lastId = 0;
		}
		else {
			$newId = 'guest_'.($users->lastId + 1);
			$users->lastId += 1;
		}
		$newUser->mmr = 1;
		$newUser->chat = null;
		$newUser->visited = time();
		$users->$newId = $newUser;
		setJsonToFile('tmp/users.json', $users);
		$_SESSION['user'] = $newId;
		return $newId;
		}
?>
