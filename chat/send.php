<?php

session_start();

require '../config/database.php';

if (!isset($_SESSION['conversation_id'])) {
    exit("Conversation not found.");
}

$conversationId = $_SESSION['conversation_id'];

$message = trim($_POST['message'] ?? '');

if ($message == '') {
    exit("Empty message.");
}

/*
|--------------------------------------------------------------------------
| Get Current Visitor Info
|--------------------------------------------------------------------------
*/

$stmt = $conn->prepare("
SELECT
    visitor_name,
    visitor_phone,
    visitor_email
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
| Auto Save Visitor Information
|--------------------------------------------------------------------------
*/

if(empty($conversation['visitor_name'])){

    $stmt=$conn->prepare("
    UPDATE conversations
    SET visitor_name=:value
    WHERE id=:id
    ");

    $stmt->execute([
        ":value"=>$message,
        ":id"=>$conversationId
    ]);

}
elseif(empty($conversation['visitor_phone'])){

    $stmt=$conn->prepare("
    UPDATE conversations
    SET visitor_phone=:value
    WHERE id=:id
    ");

    $stmt->execute([
        ":value"=>$message,
        ":id"=>$conversationId
    ]);

}
elseif(empty($conversation['visitor_email'])){

    $stmt=$conn->prepare("
    UPDATE conversations
    SET visitor_email=:value
    WHERE id=:id
    ");

    $stmt->execute([
        ":value"=>$message,
        ":id"=>$conversationId
    ]);

}

/*
|--------------------------------------------------------------------------
| Save Customer Message
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
'Customer',
:message
)
");

$stmt->execute([

":id"=>$conversationId,
":message"=>$message

]);

echo "OK";