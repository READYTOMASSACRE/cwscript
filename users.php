<?php

	/**
	 * add new user in users.json
	 * @return string
	 *
	 */
	function addUser($id, $obj) {

		if(isset($_SESSION['user']) && empty($id)) return $_SESSION['user'];

		$users = getJsonFromFile('users.json');
		$newUser = null;


		if (isset($id)) {
			if($users === null)  $users = new stdClass();
			$users->lastId = substr($id, 6);
			$users->count += 1;
			$users->$id = $obj;
		} 
		else {
			$users->lastId = $users->lastId === null ? 0 : $users->lastId+1;
			$users->count += 1;
			$newUser = 'guest_'.$users->lastId;
			$_SESSION['user'] = $newUser;
			$_SESSION['status'] = 0;
			$_SESSION['chat'] = null;
			$users->$newUser = getDefaultData();
		}

		setJsonToFile('users.json', $users);
		return $newUser;
	}

	/** 
	 * drop user from users.json
	 * @param array &$users
	 * @param string $user
	 * @return array
	 *
	 */
	function dropUser(&$users, $user) {
		if (empty($users) || empty($users->$user)) return false;
		$users->count -= 1;
		unset($users->$user);
		return $users;
	}

	/** 
	 * get user online
	 * @return bool
	 *
	 */
	function isUserOnline($arr, $user) {
		return $arr->$user->online;
	}

	/**
	 * drops users from users.json by timeout
	 * @param int $timeout
	 * @return execute record to file
	 *
	 */
	function dropUsersBySession($timeout) {
		$users = getJsonFromFile('users.json');
		foreach($users as $id => $user) {
			if($id[0] == 'g' &&  ((time() - $user->visited) > $timeout))
				dropUser($users, $id);
		}
		return setJsonToFile('users.json', $users);
	}

	/**
	 * set new value by key, example: updateUserData($users, 'visited', time());
	 * @param array &$arr
	 * @param string $key
	 * @param string $value
	 * @return array
	 *
	 */
	function updateUserData(&$arr, $key, $value) {
		$arr->$key = $value;
		return $arr;
	}

	/**
	 * get object new user with default stats
	 * @return object
	 *
	 */
	function getDefaultData() {
		$obj = null;
		$obj->mmr = 1;
		$obj->chat = null;
		$obj->online = true;
		$obj->visited = time();
		return $obj;
	}

?>