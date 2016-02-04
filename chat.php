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

    /**
     * get history chat if user in chat
     * @param string $username
     * @return string history or false if user is not chatting
     *
     */
    function getChat($chats, $username) {
        $chatId = isUserInChat($username);
        if($chatId) return $chats->$chatId->history;
        foreach($chats as $id => $chat) {
            if(in_array($username, $chat->members)) {
                return $chat->history;
            }
        }
        return false;
    } 

    /**
     * removing chat from chat.json
     * @param int $id
     * @return execute record to file
     *
     */
    function removeChat($id) {
        $chats = getJsonFromFile('tmp/chat.json');
        unset($chats->$id);
        return setJsonToFile('tmp/chat.json', $chats);
    }

    /**
     * send message to chat.json
     * @param string $who
     * @param string $message
     * @return history
     *
     */
    function sendChat($who, $message) {
        $chats = getJsonFromFile('tmp/chat.json');
        $id = getChatByName($chats, $who);
        if($id == -1) return false;
        $chats->$id->history.='<b>'.$who.':</b> '.$message.'<br>';
        setJsonToFile('tmp/chat.json', $chats);
        return $chats->$id->history;
    }

    /**
     * get id by $name from $chats
     * @param array $chats
     * @param string @name
     * @return string $id or false if can't found
     *
     */
    function getChatByName($chats, $name) {
        foreach($chats as $id => $chat)
            if(in_array($name, $chat->members))
                return $id;
        return -1;
    }

    /**
     * get id chat if user chatting
     * @param string $username
     * @return int id chat
     *
     */
    function isUserInChat($username) {
        $users = getJsonFromFile('tmp/users.json');
        return $users->$username->chat;
    }
?>