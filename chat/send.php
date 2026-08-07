<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

header("Content-Type: application/json");

require_once __DIR__ . '/config.php';

$conn = db();

$message = trim($_POST['message'] ?? '');

$ownerId = intval($_POST['owner_id'] ?? 0);

$visitorToken = trim($_POST['visitor_token'] ?? '');

$conversationId = intval($_POST['conversation_id'] ?? 0);


if ($message === '') {

    echo json_encode([
        "success" => false,
        "message" => "Message cannot be empty."
    ]);

    exit;
}


if ($ownerId <= 0 || $visitorToken === '') {

    echo json_encode([
        "success" => false,
        "message" => "Invalid visitor information."
    ]);

    exit;
}


/*
|--------------------------------------------------------------------------
| Find Conversation
|--------------------------------------------------------------------------
*/

if ($conversationId <= 0) {

    $stmt = $conn->prepare("
        SELECT id
        FROM chat_conversations
        WHERE owner_id = ?
        AND visitor_token = ?
        LIMIT 1
    ");

    $stmt->execute([
        $ownerId,
        $visitorToken
    ]);

    $conversation = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$conversation) {

        echo json_encode([
            "success" => false,
            "message" => "Conversation not found."
        ]);

        exit;
    }

    $conversationId = $conversation['id'];
}


/*
|--------------------------------------------------------------------------
| Verify Conversation Belongs To Owner
|--------------------------------------------------------------------------
*/

$stmt = $conn->prepare("
    SELECT *
    FROM chat_conversations
    WHERE id = ?
    AND owner_id = ?
    AND visitor_token = ?
    LIMIT 1
");

$stmt->execute([
    $conversationId,
    $ownerId,
    $visitorToken
]);

$conversation = $stmt->fetch(PDO::FETCH_ASSOC);


if (!$conversation) {

    echo json_encode([
        "success" => false,
        "message" => "Conversation not found."
    ]);

    exit;
}


/*
|--------------------------------------------------------------------------
| Save Visitor Message
|--------------------------------------------------------------------------
*/

$stmt = $conn->prepare("
    INSERT INTO chat_messages
    (
        conversation_id,
        sender,
        message
    )
    VALUES
    (
        ?,
        'Visitor',
        ?
    )
");

$stmt->execute([
    $conversationId,
    $message
]);


/*
|--------------------------------------------------------------------------
| Update Conversation
|--------------------------------------------------------------------------
*/

$stmt = $conn->prepare("
    UPDATE chat_conversations
    SET
        status = 'Unread',
        last_activity = NOW()
    WHERE id = ?
");

$stmt->execute([
    $conversationId
]);


/*
|--------------------------------------------------------------------------
| Automated Responses
|--------------------------------------------------------------------------
*/

$text = strtolower($message);

$reply = null;


/*
|--------------------------------------------------------------------------
| Greeting
|--------------------------------------------------------------------------
*/

if (
    preg_match('/\b(hello|hi|hey|good morning|good afternoon|good evening)\b/i', $text)
) {

    $reply = "Hello! How may I assist you today?";
}


/*
|--------------------------------------------------------------------------
| Thank You
|--------------------------------------------------------------------------
*/

elseif (
    preg_match('/\b(thank you|thanks|thank)\b/i', $text)
) {

    $reply = "You're welcome! Please let me know if there is anything else I can help you with.";
}


/*
|--------------------------------------------------------------------------
| Fallback
|--------------------------------------------------------------------------
*/

else {

    $reply = "I’m unable to answer that at the moment. Please wait for the owner to assist you.";
}


/*
|--------------------------------------------------------------------------
| Save Automated Reply
|--------------------------------------------------------------------------
*/

$stmt = $conn->prepare("
    INSERT INTO chat_messages
    (
        conversation_id,
        sender,
        message
    )
    VALUES
    (
        ?,
        'AI',
        ?
    )
");

$stmt->execute([
    $conversationId,
    $reply
]);


/*
|--------------------------------------------------------------------------
| Update Activity
|--------------------------------------------------------------------------
*/

$stmt = $conn->prepare("
    UPDATE chat_conversations
    SET
        last_activity = NOW()
    WHERE id = ?
");

$stmt->execute([
    $conversationId
]);



echo json_encode([
    "success" => true,
    "reply" => $reply,
    "conversation_id" => $conversationId
]);