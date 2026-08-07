<?php

require_once __DIR__ . '/config.php';

header("Content-Type: application/json");

$conn = db();

$action = trim($_POST['action'] ?? '');

$ownerId = intval($_POST['owner_id'] ?? 0);

$visitorToken = trim($_POST['visitor_token'] ?? '');

$name = trim($_POST['name'] ?? '');

$phone = trim($_POST['phone'] ?? '');

if ($ownerId <= 0 || $visitorToken === '') {

    echo json_encode([
        "success" => false,
        "message" => "Invalid visitor information."
    ]);

    exit;
}


/*
|--------------------------------------------------------------------------
| START CONVERSATION
|--------------------------------------------------------------------------
*/

if ($action === 'start') {

    /*
    |--------------------------------------------------------------------------
    | Check Existing Conversation
    |--------------------------------------------------------------------------
    */

    $stmt = $conn->prepare("
        SELECT *
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


    /*
    |--------------------------------------------------------------------------
    | Existing Conversation
    |--------------------------------------------------------------------------
    */

    if ($conversation) {

        echo json_encode([
            "success" => true,
            "conversation_id" => $conversation['id'],
            "visitor_name" => $conversation['visitor_name'],
            "visitor_phone" => $conversation['visitor_phone'],
            "existing" => true
        ]);

        exit;
    }


    /*
    |--------------------------------------------------------------------------
    | Create New Conversation
    |--------------------------------------------------------------------------
    */

    $stmt = $conn->prepare("
        INSERT INTO chat_conversations
        (
            owner_id,
            visitor_token,
            status,
            last_activity
        )
        VALUES
        (
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


    echo json_encode([
        "success" => true,
        "conversation_id" => $conversationId,
        "visitor_name" => "",
        "visitor_phone" => "",
        "existing" => false
    ]);

    exit;
}


/*
|--------------------------------------------------------------------------
| SAVE CONTACT INFORMATION
|--------------------------------------------------------------------------
*/

if ($action === 'save_contact') {

    if ($name === '' || $phone === '') {

        echo json_encode([
            "success" => false,
            "message" => "Name and phone number are required."
        ]);

        exit;
    }


    /*
    |--------------------------------------------------------------------------
    | Find Conversation
    |--------------------------------------------------------------------------
    */

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


    /*
    |--------------------------------------------------------------------------
    | Update Name + Phone
    |--------------------------------------------------------------------------
    */

    $stmt = $conn->prepare("
        UPDATE chat_conversations
        SET
            visitor_name = ?,
            visitor_phone = ?,
            last_activity = NOW()
        WHERE id = ?
        AND owner_id = ?
    ");

    $stmt->execute([
        $name,
        $phone,
        $conversationId,
        $ownerId
    ]);


    echo json_encode([
        "success" => true,
        "conversation_id" => $conversationId,
        "visitor_name" => $name,
        "visitor_phone" => $phone
    ]);

    exit;
}


echo json_encode([
    "success" => false,
    "message" => "Invalid action."
]);