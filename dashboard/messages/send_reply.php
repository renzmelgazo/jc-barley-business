<?php

require '../../config/session.php';
require '../../config/database.php';

header('Content-Type: application/json');

if(!isset($_SESSION['user_id'])){
    echo json_encode([
        'success'=>false,
        'message'=>'Unauthorized'
    ]);
    exit;
}

$conversationId = intval($_POST['conversation_id'] ?? 0);
$message = trim($_POST['message'] ?? '');

if($conversationId==0 || $message==''){
    echo json_encode([
        'success'=>false,
        'message'=>'Missing data'
    ]);
    exit;
}

/*
|--------------------------------------------------------------------------
| Verify Conversation Belongs To Owner
|--------------------------------------------------------------------------
*/

$stmt = $conn->prepare("
SELECT id
FROM chat_conversations
WHERE id = :id
AND owner_id = :owner
LIMIT 1
");

$stmt->execute([
    ':id'=>$conversationId,
    ':owner'=>$_SESSION['user_id']
]);

$exists = $stmt->fetch(PDO::FETCH_ASSOC);

if(!$exists){
    echo json_encode([
        'success'=>false,
        'message'=>'Conversation not found'
    ]);
    exit;
}

/*
|--------------------------------------------------------------------------
| Save Owner Reply
|--------------------------------------------------------------------------
*/

$stmt = $conn->prepare("
INSERT INTO chat_messages(

conversation_id,

sender,

message

)

VALUES(

:id,

:sender,

:message

)
");

$stmt->execute([
    ':id'=>$conversationId,
    ':sender'=>'Owner',
    ':message'=>$message
]);

/*
|--------------------------------------------------------------------------
| Update Conversation Status
|--------------------------------------------------------------------------
*/

$stmt = $conn->prepare("
UPDATE chat_conversations
SET

status = 'Waiting for Visitor',

updated_at = NOW()

WHERE id = :id
");

$stmt->execute([
    ':id'=>$conversationId
]);

echo json_encode([
    'success'=>true
]);