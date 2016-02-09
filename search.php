<?php 
	/**
	 * structure active_users.json
	 * @var string lastId
	 * @var int count
	 * @var string id 
	 *
	 */

	/**
	 * searching and sets links for active_users.json 
	 * @param array $arr
	 * 
	 */
	$cantSearch = false;
	

	/**
	 * clear all search links
	 * @return execute record to file
	 *
	 */
	function clearSearchLinks() {
		$users = getJsonFromFile('active_users.json');
		foreach ($users as $u) {
			$u->link = null;
		}
		return setJsonToFile('active_users.json', $users);
	}

	/**
	 * clear all search from active_users.json
	 * @return execute record to file
	 *
	 */
	function clearSearch() {
        setJsonToFile('active_users.json', null);
	}

	/**
	 * add in search users in active_users.json
	 * @return bool true if added, false if not 
	 *
	 */
	function addInSearch() {
		if ($_SESSION['status'] == (1 || 2)) return false;
		$id = $_SESSION['user'];
		$activeUsers = getJsonFromFile('active_users.json');
		$users = getJsonFromFile('users.json');
		$activeUsers->lastId = substr($id, 6);
		$activeUsers->count += 1;
		$activeUsers->$id = $users->$id->mmr;
		dropUser($users, $id);
		setJsonToFile('active_users.json', $activeUsers);
		setJsonToFile('users.json', $users);
		$GLOBALS['cantSearch'] = false;
		$_SESSION['status'] = 1;
		return $id;
	}
	
	/**
	 * drop users from active_users.json
	 * @param array &$arr
	 * @param array $users
	 * @return 
	 *
	 */
	function dropFromSearch(&$arr, $users, $chat) {
		foreach($users as $user) {
			$id = $user;
			$obj = new stdClass();
			$obj->mmr = $arr->$user;
			$obj->chat = $chat;
			$obj->online = true;
			$obj->visited = time();
			addUser($id, $obj);
			unset($arr->$user);
			$arr->count -=1;
		}
		return $arr;
	}


	function searchResult() {
		if (isset($_SESSION['chat'])) return true;
		$users = getJsonFromFile('users.json');
		if($users->$_SESSION['user']->chat === null) return false;
		$_SESSION['chat'] = $users->$_SESSION['user']->chat;
		$_SESSION['status'] = 2;
		return true;
	}
	/**
	 * get last user id in array
	 * @param array @arr
	 * @return last added user id
	 *
	 */
	function getLastUserId($arr) {
		$count = -1;
		foreach($arr as $id => $user) {
			$count = substr($id, 6);
		}
		return $count;
	}

?>