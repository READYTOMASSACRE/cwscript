<?php 
	include 'chat.php';
	include 'search.php';
	include 'utils.php';
	include 'users.php';
	if(!session_id()) session_start();

	$u = 'gg';
	function foo(&$t) {
		$t = 'zz';
		$t->key0 = 'key1';
	}
	echo $u;
	foo($u);
	echo '<br>'.$u.'<br>';
	foreach($u as $k => $v) {
		echo $k.' '.$v.'<br>';
	}
	if(isset($_REQUEST['register'])) {
		echo addUser();
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
?>
