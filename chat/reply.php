<?php

session_start();

require '../config/database.php';

if (!isset($_SESSION['chat_session'])) {
    exit;
}

$session = $_SESSION['chat_session'];

/*
|--------------------------------------------------------------------------
| Get Conversation
|--------------------------------------------------------------------------
*/

$stmt = $conn->prepare("
SELECT *
FROM ai_conversations
WHERE session_id=:session
LIMIT 1
");

$stmt->execute([
    ":session"=>$session
]);

$conversation=$stmt->fetch(PDO::FETCH_ASSOC);

if(!$conversation){
    exit;
}

/*
|--------------------------------------------------------------------------
| Last Customer Message
|--------------------------------------------------------------------------
*/

$stmt=$conn->prepare("
SELECT message
FROM conversation_messages
WHERE conversation_id=:id
AND sender='Customer'
ORDER BY id DESC
LIMIT 1
");

$stmt->execute([
":id"=>$conversation['id']
]);

$last=$stmt->fetchColumn();

$reply="";

if(empty($conversation['fullname'])){

    $reply="Nice to meet you!

May I have your full name?";

}
elseif(empty($conversation['phone'])){

    $reply="Thank you.

May I have your phone number?";

}
elseif(empty($conversation['email'])){

    $reply="Great!

May I have your email address?";

}
else{

    $reply="Thank you!

One of our representatives will contact you shortly.";

}

/*
|--------------------------------------------------------------------------
| Save AI Reply
|--------------------------------------------------------------------------
*/

$stmt=$conn->prepare("
INSERT INTO conversation_messages
(conversation_id,sender,message)
VALUES
(:id,'AI',:message)
");

$stmt->execute([

":id"=>$conversation['id'],

":message"=>$reply

]);

echo $reply;