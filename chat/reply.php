<?php

session_start();

require '../config/database.php';

if (!isset($_SESSION['conversation_id'])) {
    exit;
}

$conversationId = $_SESSION['conversation_id'];

/*
|--------------------------------------------------------------------------
| Get Conversation
|--------------------------------------------------------------------------
*/

$stmt = $conn->prepare("
SELECT *
FROM conversations
WHERE id=:id
LIMIT 1
");

$stmt->execute([
":id"=>$conversationId
]);

$conversation = $stmt->fetch(PDO::FETCH_ASSOC);

if(!$conversation){
    exit;
}

/*
|--------------------------------------------------------------------------
| AI Flow
|--------------------------------------------------------------------------
*/

if(empty($conversation['visitor_name'])){

    $reply = "Welcome! Before we continue, may I have your full name?";

}
elseif(empty($conversation['visitor_phone'])){

    $reply = "Thank you. May I have your phone number?";

}
elseif(empty($conversation['visitor_email'])){

    $reply = "Great! May I also have your email address?";

}
else{

    $reply = "Thank you! One of our representatives will contact you shortly. If our owner is online, they may join this conversation directly.";

}

/*
|--------------------------------------------------------------------------
| Save AI Message
|--------------------------------------------------------------------------
*/

$stmt = $conn->prepare("
INSERT INTO conversation_messages
(
conversation_id,
sender,
message
)
VALUES
(
:id,
'AI',
:message
)
");

$stmt->execute([

":id"=>$conversationId,
":message"=>$reply

]);

echo $reply;