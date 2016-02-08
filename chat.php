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
        $chats->lastId = $chats->lastId === null ? 0 : $chats->lastId+1;
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
    function getChatHistory($id) {
        $chats = getJsonFromFile('tmp/chat.json');
        if($id) return $chats->$id->history;
        return false;
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
        $id = $_SESSION['chat'];
        if($id === null || $chats->$id === null) return false;
        if (empty($chats->$id->history)) $chats->$id->history = array();
        $formattedMessage = '<b>'.$who.':</b> '.$message.'<br>';
        array_push($chats->$id->history, $formattedMessage);
        setJsonToFile('tmp/chat.json', $chats);
        return json_encode($chats->$id->history);
    }

    function showChat() {
        $users = getJsonFromFile('tmp/users.json');
        if(isset($users->$_SESSION['user']->chat)) {
            $_SESSION['status'] = 2;
            $_SESSION['chat'] = $users->$_SESSION['user']->chat;
            return getChatHistory($_SESSION['chat']);
        }
        return false;
    }
?>