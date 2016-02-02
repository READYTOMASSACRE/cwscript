<?php 
	if(!session_id()) session_start();
	include 'utils.php';
	include 'search.php';
	include 'chat.php';

	$users = getJsonFromFile('tmp/active_users.json');
	echo 'before<br>';
	var_dump($users);
	dropFromSearch($users, array("guest_1", "guest_0"));
	echo '<br>after<br>';
	var_dump($users);

	//dropFromSearch($users, $removeUsers);
	/*searchHandler() {
		$users = getJsonFromFile('tmp/active_users.json');
		foreach($users as $id => $u) {
			if(isset($u->link)) {
				addChat(array($id, $u->link));	
				dropFromSearch($users, array($id, $u->link));
			}
		}
	}*/
?>
