<?php 
	/**
	 * structure active_users.json
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
	function search($arr) {
		$arr = getJsonFromFile('tmp/active_users.json');
		foreach ($arr as $id => $u) {
			findOpponent($arr, $id);
		}
		setJsonToFile('tmp/active_users.json', $arr);
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
			if($finder != $target) {
				if(empty($u->link) && ($users->$finder->mmr <= $u->mmr)) {
					$users->$finder->link = $target;
					$u->link = $finder;
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
	 * @TODO realize add users by id (not autoincrement if this not firsttime)
	 * @param string $userId 
	 * @var
	 * @return string Added user id
	 */
	function addInSearch() {
		$users = getJsonFromFile('tmp/active_users.json');
		$user = (object) array("link" => null, "mmr" => 1);
		$lastId = 'guest_'.(getLastUserId($users)+1);
		echo 'lastId: '.$lastId.'<br>';
		$users->$lastId = $user;
		setJsonToFile('tmp/active_users.json', $users);
		return $user->id;
	}
	
	/**
	 * drop users from active_users.json
	 * @param array &$arr
	 * @param array $users
	 * @return 
	 *
	 */
	function dropFromSearch(&$arr, $users) {
		foreach($arr as $id => $u) {
			if (in_array($id, $users)) {
					if (isset($u->link)) {
						$userlink = $u->link;
						$arr->$userlink->link = null;
					}
					unset($arr->$id);
			}
		}
		setJsonToFile('tmp/active_users.json', $arr);
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