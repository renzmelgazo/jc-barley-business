<?php

require '../config/database.php';

session_start();

$data=json_decode(file_get_contents("php://input"),true);

$ownerId=$data['owner_id'];

$message=strtolower(trim($data['message']));

$visitorId=$_SESSION['visitor_id'];

$reply="Thank you for contacting us. One of our representatives will assist you shortly.";

/*
|--------------------------------------------------------------------------
| Basic AI
|--------------------------------------------------------------------------
*/

if(str_contains($message,"price"))
{
$reply="May I know which product are you interested in?";
}

elseif(str_contains($message,"hello"))
{
$reply="Hello! 👋 Welcome to our website. How can I help you today?";
}

elseif(str_contains($message,"hi"))
{
$reply="Hi there! 😊 How may I assist you?";
}

elseif(str_contains($message,"location"))
{
$reply="May I know where you are located?";
}

elseif(str_contains($message,"buy"))
{
$reply="Great! May I have your Full Name, Phone Number, and Email Address so our team can contact you?";
}

/*
|--------------------------------------------------------------------------
| Save AI Reply
|--------------------------------------------------------------------------
*/

$stmt=$conn->prepare("
INSERT INTO ai_conversations
(owner_id,visitor_id,sender,message)
VALUES
(:owner,:visitor,'ai',:message)
");

$stmt->execute([
':owner'=>$ownerId,
':visitor'=>$visitorId,
':message'=>$reply
]);

echo json_encode([
"reply"=>$reply
]);