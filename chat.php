<?php 
    /**
     * chat.json structure
     * @var string $id
     * $id -> @var array $members
     * $id -> @var string $history
     *
     */

    /**
     * add new chat in chat.json
     * @param array $members
     * @return execute record to file
     *
     */
    function addChat($members) {
        $chats = getJsonFromFile('tmp/chat.json');
        $newId = getLastChatId($chats)+1;
        $newChat = null;
        $newChat->members = $members;
        $newChat->history = null;
        $chats->$newId = $newChat;
        return setJsonToFile('tmp/chat.json', $chats);
    }

    /**
     * clear chat.json
     * @return execute record to file
     *
     */
    function clearChat() {
        return setJsonToFile('tmp/chat.json', null);
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