<?php
session_start();
require "../config/database.php";

$ownerSlug = $_GET['owner'] ?? '';

$stmt = $conn->prepare("
SELECT id
FROM users
WHERE site_slug=:slug
LIMIT 1
");

$stmt->execute([
":slug"=>$ownerSlug
]);

$owner=$stmt->fetch(PDO::FETCH_ASSOC);

if(!$owner){
exit;
}

$ownerId=$owner['id'];

$_SESSION['chat_owner']=$ownerId;

if(!isset($_SESSION['conversation_id'])){

$stmt=$conn->prepare("
INSERT INTO conversations
(owner_id)
VALUES
(:owner)
");

$stmt->execute([
":owner"=>$ownerId
]);

$_SESSION['conversation_id']=$conn->lastInsertId();

}

echo $_SESSION['conversation_id'];