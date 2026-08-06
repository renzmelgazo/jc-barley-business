<?php

header("Content-Type: application/json");

require "config.php";
require "gemini.php";

$conn = db();

$message = trim($_POST['message'] ?? '');

$ownerId = intval($_POST['owner_id'] ?? 0);

if($message==""){

    echo json_encode([
        "success"=>false
    ]);

    exit;

}

/*
|--------------------------------------------------------------------------
| Find Pending Conversation
|--------------------------------------------------------------------------
*/

$stmt = $conn->prepare("
SELECT id
FROM chat_conversations
WHERE owner_id=?
AND visitor_name IS NULL
ORDER BY id DESC
LIMIT 1
");

$stmt->execute([$ownerId]);

$conversation = $stmt->fetch(PDO::FETCH_ASSOC);

/*
|--------------------------------------------------------------------------
| Create Conversation
|--------------------------------------------------------------------------
*/

if(!$conversation){

    $stmt = $conn->prepare("
    INSERT INTO chat_conversations(owner_id)
    VALUES(?)
    ");

    $stmt->execute([$ownerId]);

    $conversationId = $conn->lastInsertId();

}else{

    $conversationId = $conversation['id'];

}

/*
|--------------------------------------------------------------------------
| Save Visitor Message
|--------------------------------------------------------------------------
*/

$stmt = $conn->prepare("
INSERT INTO chat_messages(

conversation_id,

sender,

message

)

VALUES(?,?,?)
");

$stmt->execute([

$conversationId,

'Visitor',

$message

]);

/*
|--------------------------------------------------------------------------
| Ask AI
|--------------------------------------------------------------------------
*/

$reply = askGemini($message);

/*
|--------------------------------------------------------------------------
| Save AI Reply
|--------------------------------------------------------------------------
*/

$stmt = $conn->prepare("
INSERT INTO chat_messages(

conversation_id,

sender,

message

)

VALUES(?,?,?)
");

$stmt->execute([

$conversationId,

'AI',

$reply

]);

echo json_encode([

"success"=>true,

"reply"=>$reply,

"conversation_id"=>$conversationId

]);