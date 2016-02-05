<?php

	/**
	 * add new user in users.json
	 * @return string
	 *
	 */
	function addUser($id, $obj) {
		if(isset($_SESSION['user']) && empty($id)) return false;

		$newUser = null;
		$users = getJsonFromFile('tmp/users.json');
		$users->count += 1;
		
		if (isset($id)) {
			$users->$id = $obj;
			$users->lastId = $id;
		} 
		else {
			$users->lastId = $users ? $users->lastId+1 : 0;
			$newUser = 'guest_'.$users->lastId;
			$_SESSION['user'] = $newUser;
			$users->$newUser = getDefaultData();
		}
		setJsonToFile('tmp/users.json', $users);
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
	function dropUsersBySession(int $timeout) {
		$users = getJsonFromFile('tmp/users.json');
		foreach($users as $id => $user) {
			if($id[0] == 'g' &&  ((time() - $user->visited) > $timeout))
				dropUser($users, $id);
		}
		return setJsonToFile('tmp/users.json', $users);
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