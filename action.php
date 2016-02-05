<?php
	$input = file_get_contents('tmp/users.json');
	$tmp = json_decode($input);
	$new_user = (object) array('id' => 'guest_1', 'mmr' => '3');

	$chat_json = file_get_contents('tmp/chat.json');
	$chat_json = json_decode($chat_json);
	$template_chat = (object) array('id' => '', 'session1' => null, 'session2' => null, 'history' => '');
	$template_chat1 = (object) array('id' => '', 'session1' => session_id(), 'session2' => null, 'history' => '');
	$template_chat2 = (object) array('id' => '', 'session1' => null, 'session2' => session_id(), 'history' => '');
	$template_chat3 = (object) array('id' => '', 'session1' => null, 'session2' => null, 'history' => '');
	$chats = $chat_json;
	array_push($chats, $template_chat);
	array_push($chats, $template_chat1);
	array_push($chats, $template_chat2);
	array_push($chats, $template_chat3);
	chat();

	function chat() {
		global $chats;
		foreach($chats as $key => $value) {
			if ( ($value->session1 || $value->session2) == session_id() ) {
				print('in chat ['.$key.'] have session id '.session_id().'<br>'); 

				//break;
			}
		}		
	}

	function foo() { echo 'foo'; }

	if ($_REQUEST['param'] == 'add') {
		$new_id = count($tmp)+1;
		$new_user->id = 'guest_'.$new_id;
		array_push($tmp, $new_user);
		$json_data = json_encode($tmp);
		file_put_contents('tmp/users.json', $json_data);
		echo $new_user->id;
	}

	if ($_REQUEST['param'] == 'last-id') {
		$last_id = '';
		foreach ($tmp as $value) 
			$last_id =  $value->id;
		echo $last_id;
	}
	if ($_REQUEST['param'] == 'clear') {
		$clear_data = '[]';
		file_put_contents('tmp/users.json', $clear_data);
	}


	$chat = getJsonFromFile('tmp/chat.json');
	array_push($chat, $template_chat);
	setJsonToFile($chat, 'tmp/chat.json');

	if($_REQUEST['param'] == 'chatSend') {
		$chat = getJsonFromFile('tmp/chat.json');
		foreach($chat as $key => $var) {

		}
	}
	
	chatUpdate();
	function chatUpdate() {
		$chat = getJsonFromFile('tmp/chat.json');
		var_dump($chat);
	}


/* 	if($_REQUEST['param'] == 'chatSend') {
		$msg  = $_POST['message'];
		$msg = json_decode($msg);
		$session = session_id();
		$chat_id = getChatId($session);
		if (!$chat_id) {
			$new_chat = (object) array ('id' => count($chat_json)+1, 'session_1' => $session, 'session_2' => '', 'history' => $msg);
			array_push($chat_json, $new_chat);
		}
		$chat_json[$chat_id]->history .= msg;
		$chat_json = json_encode($chat_json);
		file_put_contents('tmp/chat.json', $chat_json);
	}
	if($_REQUEST['param'] == 'chatRefresh') {
		$session = session_id();
		foreach ($chat_json as $key => $value) {
			# code...
			if ( ($value->$session_1 || $value->session_2) == $session ) {
				echo $value->history; 
				break;
			}
		}
	} */




?>
