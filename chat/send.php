<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

header("Content-Type: application/json");

require "config.php";

$conn = db();


/*
|--------------------------------------------------------------------------
| Receive Data
|--------------------------------------------------------------------------
*/

$message =
    trim($_POST['message'] ?? '');

$ownerId =
    intval($_POST['owner_id'] ?? 0);

$visitorToken =
    trim($_POST['visitor_token'] ?? '');

$visitorName =
    trim($_POST['visitor_name'] ?? '');

$visitorPhone =
    trim($_POST['visitor_phone'] ?? '');


/*
|--------------------------------------------------------------------------
| Validate
|--------------------------------------------------------------------------
*/

if (
    $message === "" ||
    $ownerId <= 0 ||
    $visitorToken === ""
) {

    echo json_encode([
        "success" => false
    ]);

    exit;
}


/*
|--------------------------------------------------------------------------
| Find Existing Conversation
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

$conversation =
    $stmt->fetch(PDO::FETCH_ASSOC);


/*
|--------------------------------------------------------------------------
| Create Conversation
|--------------------------------------------------------------------------
*/

if (!$conversation) {

    $stmt = $conn->prepare("
        INSERT INTO chat_conversations
        (
            owner_id,
            visitor_token,
            visitor_name,
            visitor_phone,
            status,
            last_activity
        )
        VALUES
        (
            ?,
            ?,
            ?,
            ?,
            'Unread',
            NOW()
        )
    ");

    $stmt->execute([
        $ownerId,
        $visitorToken,
        $visitorName,
        $visitorPhone
    ]);


    $conversationId =
        $conn->lastInsertId();

} else {

    $conversationId =
        $conversation['id'];


    /*
    |--------------------------------------------------------------------------
    | Update Visitor Information
    |--------------------------------------------------------------------------
    */

    $stmt = $conn->prepare("
        UPDATE chat_conversations
        SET
            visitor_name = ?,
            visitor_phone = ?,
            status = 'Unread',
            last_activity = NOW()
        WHERE id = ?
        AND owner_id = ?
    ");

    $stmt->execute([
        $visitorName,
        $visitorPhone,
        $conversationId,
        $ownerId
    ]);

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
| Update Conversation Activity
|--------------------------------------------------------------------------
*/

$stmt = $conn->prepare("
    UPDATE chat_conversations
    SET
        visitor_name = ?,
        visitor_phone = ?,
        status = 'Unread',
        last_activity = NOW()
    WHERE id = ?
    AND owner_id = ?
");

$stmt->execute([
    $visitorName,
    $visitorPhone,
    $conversationId,
    $ownerId
]);


/*
|--------------------------------------------------------------------------
| Success
|--------------------------------------------------------------------------
*/

echo json_encode([

    "success" => true,

    "conversation_id" =>
        $conversationId

]);

exit;