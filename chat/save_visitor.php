<?php

session_start();

require '../config/database.php';

/*
|--------------------------------------------------------------------------
| Get Owner
|--------------------------------------------------------------------------
*/

$ownerId = isset($_POST['owner_id']) ? (int)$_POST['owner_id'] : 0;

if ($ownerId <= 0) {
    exit("Invalid owner.");
}

/*
|--------------------------------------------------------------------------
| Visitor Info
|--------------------------------------------------------------------------
*/

$fullname = trim($_POST['fullname'] ?? '');
$email    = trim($_POST['email'] ?? '');
$phone    = trim($_POST['phone'] ?? '');

/*
|--------------------------------------------------------------------------
| Session
|--------------------------------------------------------------------------
*/

if (!isset($_SESSION['chat_session'])) {

    $_SESSION['chat_session'] = bin2hex(random_bytes(16));

}

$sessionId = $_SESSION['chat_session'];

/*
|--------------------------------------------------------------------------
| Check Existing Conversation
|--------------------------------------------------------------------------
*/

$stmt = $conn->prepare("
SELECT *
FROM ai_conversations
WHERE session_id = :session_id
LIMIT 1
");

$stmt->execute([
    ':session_id' => $sessionId
]);

$conversation = $stmt->fetch(PDO::FETCH_ASSOC);

/*
|--------------------------------------------------------------------------
| Create Conversation
|--------------------------------------------------------------------------
*/

if (!$conversation) {

    $stmt = $conn->prepare("
    INSERT INTO ai_conversations
    (
        owner_id,
        session_id,
        fullname,
        email,
        phone
    )
    VALUES
    (
        :owner_id,
        :session_id,
        :fullname,
        :email,
        :phone
    )
    ");

    $stmt->execute([

        ':owner_id'   => $ownerId,
        ':session_id' => $sessionId,
        ':fullname'   => $fullname,
        ':email'      => $email,
        ':phone'      => $phone

    ]);

    $conversationId = $conn->lastInsertId();

} else {

    $conversationId = $conversation['id'];

    /*
    |--------------------------------------------------------------------------
    | Update Missing Information
    |--------------------------------------------------------------------------
    */

    $stmt = $conn->prepare("
    UPDATE ai_conversations
    SET

        fullname = CASE
            WHEN fullname='' OR fullname IS NULL
            THEN :fullname
            ELSE fullname
        END,

        email = CASE
            WHEN email='' OR email IS NULL
            THEN :email
            ELSE email
        END,

        phone = CASE
            WHEN phone='' OR phone IS NULL
            THEN :phone
            ELSE phone
        END

    WHERE id = :id
    ");

    $stmt->execute([

        ':fullname' => $fullname,
        ':email'    => $email,
        ':phone'    => $phone,
        ':id'       => $conversationId

    ]);

}

echo json_encode([

    "success" => true,
    "conversation_id" => $conversationId

]);