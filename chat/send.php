<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
header("Content-Type: application/json");

require "config.php";
require "gemini.php";

$conn = db();

$message = trim($_POST['message'] ?? '');

$ownerId = intval($_POST['owner_id'] ?? 0);
$visitorToken =
trim($_POST['visitor_token'] ?? '');

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
SELECT *

FROM chat_conversations

WHERE owner_id=?

AND visitor_token=?

LIMIT 1
");

$stmt->execute([
    $ownerId,
    $visitorToken
]);

$conversation = $stmt->fetch(PDO::FETCH_ASSOC);

/*
|--------------------------------------------------------------------------
| Create Conversation
|--------------------------------------------------------------------------
*/

if(!$conversation){

    $stmt = $conn->prepare("
    INSERT INTO chat_conversations(

owner_id,

visitor_token,

status

)

VALUES(

?,

?,

'Open'

)
    ");

    $stmt->execute([

$ownerId,

$visitorToken

]);

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