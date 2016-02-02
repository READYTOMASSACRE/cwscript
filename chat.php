<?php 
	include 'utils.php';

    /**
     * chat.json structure
     * @var string $id
     * $id -> @var array $members
     * $id -> @var string $history
     *
     */

    function addChat($members) {
        $chats = getJsonFromFile('tmp/chat.json');
        $newId = getLastChatId($chat);
        $newChat = null;
        $newChat->members = $members;
        $newChat->history = null;
        $chats->$newId = $newChat;
        setJsonToFile('tmp/chat.json', $chats);
    }

    /**
     * get last user id in array
     * @param array @arr
     * @return last added user id
     *
     */
    function getLastChatId($arr) {
        $count = -1;
        foreach($arr as $id => $user) $count = $id;
        return $count;
    }
?>