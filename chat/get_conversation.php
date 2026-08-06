<?php

require "config.php";

$conn = db();

$token = $_COOKIE['visitor_token'] ?? '';

$ownerId = intval($_GET['owner_id'] ?? 0);

if($token==""){

    exit;

}

$stmt = $conn->prepare("
SELECT id
FROM chat_conversations
WHERE owner_id=?
AND visitor_token=?
LIMIT 1
");

$stmt->execute([

$ownerId,

$token

]);

$row = $stmt->fetch(PDO::FETCH_ASSOC);

if($row){

    echo $row['id'];

}