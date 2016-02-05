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
	
	function search() {
		if($GLOBALS['cantSearch']) return false;
		$users = getJsonFromFile('tmp/active_users.json');
		foreach ($users as $id => $u) {
			if ($id[0] == 'g')
				findOpponent($users, $id);
		}

		$GLOBALS['cantSearch'] = true;
		setJsonToFile('tmp/active_users.json', $arr);
		return $arr;
	}

	/**
	 * find opponents by finder 
	 * @param &array $users
	 * @param string $finder
	 * @return false if $finder already find opponent else true
	 *
	 */
	function findOpponent(&$users, $finder) {
		foreach ($users as $target => $value) {
			if($finder != $target) {
				if($users->$finder >= $value) {
					$chatId = addChat(array($finder, $target));
					dropFromSearch($users, array($finder, $target), $chatId);
					break;
				}
			}
		}
		return true;
	}

	/**
	 * clear all search links
	 * @return execute record to file
	 *
	 */
	function clearSearchLinks() {
		$users = getJsonFromFile('tmp/active_users.json');
		foreach ($users as $u) {
			$u->link = null;
		}
		return setJsonToFile('tmp/active_users.json', $users);
	}

	/**
	 * clear all search from active_users.json
	 * @return execute record to file
	 *
	 */
	function clearSearch() {
        setJsonToFile('tmp/active_users.json', null);
	}

	/**
	 * add in search users in active_users.json
	 * @return bool true if added, false if not 
	 *
	 */
	function addInSearch() {
		if ($_SESSION['status'] == (1 || 2)) return false;
		$id = $_SESSION['user'];
		$activeUsers = getJsonFromFile('tmp/active_users.json');
		$users = getJsonFromFile('tmp/users.json');
		$activeUsers->lastId = $id;
		$activeUsers->count += 1;
		$activeUsers->$id = $users->$id->mmr;
		dropUser($users, $id);
		setJsonToFile('tmp/active_users.json', $activeUsers);
		setJsonToFile('tmp/users.json', $users);
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
			$obj->mmr = $arr->$user->mmr;
			$obj->chat = $chat;
			$obj->online = true;
			$obj->visited = time();
			addUser($id, $obj);
			unset($arr->$user);
			$arr->count -=1;
		}
		return $arr;
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