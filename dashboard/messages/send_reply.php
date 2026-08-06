<?php

require '../../config/session.php';
require '../../config/database.php';

header("Content-Type: application/json");

if(!isset($_SESSION['user_id'])){
    exit;
}

$conversationId = intval($_POST['conversation_id'] ?? 0);

$message = trim($_POST['message'] ?? '');

if($conversationId==0 || $message==""){

    echo json_encode([
        "success"=>false
    ]);

    exit;

}

/*
|--------------------------------------------------------------------------
| Save Owner Reply
|--------------------------------------------------------------------------
*/

$stmt = $conn->prepare("
INSERT INTO chat_messages(

conversation_id,

sender,

message

)

VALUES(

:conversation,

'Owner',

:message

)
");

$stmt->execute([

':conversation'=>$conversationId,

':message'=>$message

]);

/*
|--------------------------------------------------------------------------
| Update Conversation Status
|--------------------------------------------------------------------------
*/

$stmt = $conn->prepare("
UPDATE chat_conversations

SET

status='Replied',

last_activity=NOW()

WHERE id=:id
");

$stmt->execute([

':id'=>$conversationId

]);

echo json_encode([

"success"=>true

]);