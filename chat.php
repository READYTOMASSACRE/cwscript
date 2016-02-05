<?php 
    /**
     * chat.json structure
     * @var int lastId
     * @var int count
     * @var string ID
     *  @var array $members
     *  @var array $history
     *
     */

    /**
     * add new chat in chat.json
     * @param array $members
     * @return int
     *
     */
    function addChat($members) {
        $chats = getJsonFromFile('tmp/chat.json');
        $chats->lastId = $chats->lastId != null ? $chats->lastId+1 : 0;
        $chats->count += 1;
        $newId = $chats->lastId;
        $newChat = null;
        $newChat->members = $members;
        $newChat->history = null;
        $chats->$newId = $newChat;
        setJsonToFile('tmp/chat.json', $chats);
        return $newId;
    }

    /**
     * clear chat.json
     * @return execute record to file
     *
     */
    function clearChats() {
        return setJsonToFile('tmp/chat.json', null);
    }

    /**
     * get history chat if user in chat
     * @param string $username
     * @return string history or false if user is not chatting
     *
     */
    function getChatHistory($user) {
        $chats = getJsonFromFile('tmp/chat.json');
        $id = getChatByName($user);
        if($id) return $chats->$id->history;
    } 

    /**
     * drop chat from chat.json
     * @param int $id
     * @return execute record to file
     *
     */
    function dropChat($id) {
        $chats = getJsonFromFile('tmp/chat.json');
        unset($chats->$id);
        $chats->count -= 1;
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
        $id = getChatByName($who);
        if(empty($id) || $chats->$id) return false;
        if (empty($chats->$id->history)) $chats->$id->history = array();
        $formattedMessage = '<b>'.$who.':</b> '.$message.'<br>';
        array_push($chats->$id->history, $formattedMessage);
        setJsonToFile('tmp/chat.json', $chats);
        return json_encode($chats->$id->history);
    }

    /**
     * get chat by $name
     * @param string $name
     * @return id
     *
     */
    function getChatByName($name) {
        $users = getJsonFromFile('tmp/users.json');
        return $users->$name->chat;
    }

?>