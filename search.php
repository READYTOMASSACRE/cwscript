<?php 
	/**
	 * structure active_users.json
	 * @var string lastId
	 * @var int count
	 * @var string id 
	 * id -> @var string link
	 * id -> @var int mmr
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
		if(isset($users->$finder->link)) return false;
		//echo 'Вхождение в функцию getit($users, $finder), с параметром '.$finder.'<br>';
		foreach ($users as $target => $u) {
			if($finder != $target && empty($u->link)) {
				if($users->$finder->mmr >= $u->mmr) {
					$users->$finder->link = $target;
					$u->link = $finder;
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
		$info = null;
		$info->link = null;
		$info->mmr = $users->$id->mmr;
		$info->visited = $users->$id->visited;
		$activeUsers->$id = $info;
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