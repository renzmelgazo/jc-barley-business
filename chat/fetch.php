<?php

session_start();

require "../config/database.php";

$conversation=$_SESSION['conversation_id'];

$stmt=$conn->prepare("
SELECT *
FROM conversation_messages
WHERE conversation_id=:conversation
ORDER BY id ASC
");

$stmt->execute([
":conversation"=>$conversation
]);

echo json_encode(

$stmt->fetchAll(PDO::FETCH_ASSOC)

);