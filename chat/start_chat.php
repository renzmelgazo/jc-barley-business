<?php

header("Content-Type: application/json");

require "config.php";

$conn = db();

$ownerId = intval($_POST['owner_id'] ?? 0);

$name = trim($_POST['name'] ?? '');
$phone = trim($_POST['phone'] ?? '');
$email = trim($_POST['email'] ?? '');

if($name=="" || $phone==""){

    echo json_encode([
        "success"=>false,
        "message"=>"Please enter your name and phone number."
    ]);

    exit;

}

/*
|--------------------------------------------------------------------------
| Visitor Token
|--------------------------------------------------------------------------
*/

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

/*
|--------------------------------------------------------------------------
| Check Existing Conversation
|--------------------------------------------------------------------------
*/

$stmt = $conn->prepare("
SELECT id
FROM chat_conversations
WHERE owner_id=?
AND visitor_token=?
LIMIT 1
");

$stmt->execute([

    $ownerId,

    $visitorToken

]);

$row = $stmt->fetch(PDO::FETCH_ASSOC);

if($row){

    $stmt = $conn->prepare("
    UPDATE chat_conversations
    SET

    visitor_name=?,

    visitor_phone=?,

    visitor_email=?

    WHERE id=?
    ");

    $stmt->execute([

        $name,

        $phone,

        $email,

        $row['id']

    ]);

    echo json_encode([

        "success"=>true,

        "conversation_id"=>$row['id']

    ]);

    exit;

}

/*
|--------------------------------------------------------------------------
| Create Conversation
|--------------------------------------------------------------------------
*/

$stmt = $conn->prepare("
INSERT INTO chat_conversations(

owner_id,

visitor_token,

visitor_name,

visitor_phone,

visitor_email,

status,

last_activity

)

VALUES(

?,

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

    $name,

    $phone,

    $email

]);

echo json_encode([

    "success"=>true,

    "conversation_id"=>$conn->lastInsertId()

]);