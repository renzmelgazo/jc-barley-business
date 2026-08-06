<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
header("Content-Type: application/json");

require "config.php";


$conn = db();

$message = trim($_POST['message'] ?? '');

$ownerId = intval($_POST['owner_id'] ?? 0);
if(empty($_COOKIE['visitor_token'])){

    $visitorToken = bin2hex(random_bytes(16));

    setcookie(
        "visitor_token",
        $visitorToken,
        time() + (86400 * 365),
        "/"
    );

}else{

    $visitorToken = $_COOKIE['visitor_token'];

}

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

status,

last_activity

)

VALUES(

?,

?,

'Unread',

NOW()

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





$stmt = $conn->prepare("
UPDATE chat_conversations
SET

status='Unread',

last_activity=NOW()

WHERE id=?
");

$stmt->execute([
    $conversationId
]);



echo json_encode([

    "success"=>true,

    "conversation_id"=>$conversationId

]);