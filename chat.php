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
        $chats = getJsonFromFile('chat.json');
        if ($chats === null) $chats = new stdClass();
        $chats->lastId = $chats->lastId === null ? 0 : $chats->lastId+1;
        $chats->count += 1;
        $newId = $chats->lastId;
        $newChat = new stdClass();
        $newChat->members = $members;
        $newChat->history = null;
        $chats->$newId = $newChat;
        setJsonToFile('chat.json', $chats);
        return $newId;
    }

    /**
     * clear chat.json
     * @return execute record to file
     *
     */
    function clearChats() {
        return setJsonToFile('chat.json', null);
    }

    /**
     * get history chat if user in chat
     * @param string $username
     * @return string history or false if user is not chatting
     *
     */
    function getChatHistory($id, $chats) {
    if ($chats === null) $chats = getJsonFromFile('chat.json');
    if($id === null) return false; 
    $history = $chats->$id->history;
        foreach($history as $id => $message) {
            $iterator = strpos($message,":");
            if ($_SESSION['user'] == substr($message, 0, $iterator))
                $message = '<b>You</b>'.substr($message, $iterator);
            else {
                $message = '<b>'.substr($message, 0, $iterator).'</b>'.substr($message, $iterator);
            }
            $message .= '<br>';
            $history[$id] = $message;
        }
        return json_encode($history);
        
    } 

    /**
     * drop chat from chat.json
     * @param int $id
     * @return execute record to file
     *
     */
    function dropChat($id) {
        $chats = getJsonFromFile('chat.json');
        unset($chats->$id);
        $chats->count -= 1;
        return setJsonToFile('chat.json', $chats);
    }

    /**
     * send message to chat.json
     * @param string $who
     * @param string $message
     * @return history
     *
     */
    function sendChat($who, $message) {
        $chats = getJsonFromFile('chat.json');
        $id = $_SESSION['chat'];
        if($id === null || $chats->$id === null) return false;
        if (empty($chats->$id->history)) $chats->$id->history = array();
        $formattedMessage = $who.': '.$message;
        array_push($chats->$id->history, $formattedMessage);
        setJsonToFile('chat.json', $chats);
        return getChatHistory($id, $chats);
    }

    function showChat() {
        $users = getJsonFromFile('users.json');
        if(isset($users->$_SESSION['user']->chat)) {
            $_SESSION['status'] = 2;
            $_SESSION['chat'] = $users->$_SESSION['user']->chat;
            return getChatHistory($_SESSION['chat']);
        }
        return false;
    }
?>