<?php

session_start();
require '../config/database.php';

$ownerId = (int)($_POST['owner_id'] ?? 0);

if($ownerId<=0){
    exit("Invalid Owner");
}

if(!isset($_SESSION['chat_session'])){
    $_SESSION['chat_session']=bin2hex(random_bytes(16));
}

$session=$_SESSION['chat_session'];

$stmt=$conn->prepare("
SELECT id
FROM conversations
WHERE session_id=:session
LIMIT 1
");

$stmt->execute([
":session"=>$session
]);

$conversation=$stmt->fetch(PDO::FETCH_ASSOC);

if(!$conversation){

$stmt=$conn->prepare("
INSERT INTO conversations
(owner_id,session_id,status,created_at)
VALUES
(:owner,:session,'Open',NOW())
");

$stmt->execute([
":owner"=>$ownerId,
":session"=>$session
]);

$conversationId=$conn->lastInsertId();

}else{

$conversationId=$conversation['id'];

}

$_SESSION['conversation_id']=$conversationId;

echo json_encode([
"success"=>true
]);