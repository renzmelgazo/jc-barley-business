<?php

require_once __DIR__ . '/config.php';

header("Content-Type: application/json");

$conn = db();

$ownerId = intval($_GET['owner_id'] ?? 0);

$visitorToken = trim($_GET['visitor_token'] ?? '');

$conversationId = intval($_GET['conversation_id'] ?? 0);


if (
    $ownerId <= 0 ||
    $visitorToken === '' ||
    $conversationId <= 0
) {

    echo json_encode([
        "success" => false,
        "messages" => []
    ]);

    exit;
}


/*
|--------------------------------------------------------------------------
| Verify Conversation
|--------------------------------------------------------------------------
*/

$stmt = $conn->prepare("
    SELECT id
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
        "messages" => []
    ]);

    exit;
}


/*
|--------------------------------------------------------------------------
| Get Messages
|--------------------------------------------------------------------------
*/

$stmt = $conn->prepare("
    SELECT
        id,
        sender,
        message,
        created_at
    FROM chat_messages
    WHERE conversation_id = ?
    ORDER BY id ASC
");

$stmt->execute([
    $conversationId
]);

$messages = $stmt->fetchAll(PDO::FETCH_ASSOC);


echo json_encode([
    "success" => true,
    "messages" => $messages
]);