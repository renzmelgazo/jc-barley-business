<?php

session_start();

require '../config/database.php';

if (!isset($_SESSION['chat_session'])) {
    exit;
}

$sessionId = $_SESSION['chat_session'];

/*
|--------------------------------------------------------------------------
| Get Conversation
|--------------------------------------------------------------------------
*/

$stmt = $conn->prepare("
SELECT id
FROM ai_conversations
WHERE session_id = :session_id
LIMIT 1
");

$stmt->execute([
    ':session_id' => $sessionId
]);

$conversation = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$conversation) {
    exit;
}

$conversationId = $conversation['id'];

$reply = "Thank you for your message. One of our representatives will contact you shortly. May I also have your name, phone number, or email address so we can assist you better?";

/*
|--------------------------------------------------------------------------
| Save AI Reply
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
    :conversation_id,
    'AI',
    :message
)
");

$stmt->execute([

    ':conversation_id' => $conversationId,
    ':message' => $reply

]);

echo $reply;