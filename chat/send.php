<?php

session_start();

require '../config/database.php';

if (!isset($_SESSION['chat_session'])) {
    exit("No session.");
}

$sessionId = $_SESSION['chat_session'];

$message = trim($_POST['message'] ?? '');

if ($message == '') {
    exit("Empty message.");
}

/*
|--------------------------------------------------------------------------
| Find Conversation
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
    exit("Conversation not found.");
}

$conversationId = $conversation['id'];

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
    :conversation_id,
    'Customer',
    :message
)
");

$stmt->execute([

    ':conversation_id' => $conversationId,
    ':message' => $message

]);

echo "OK";