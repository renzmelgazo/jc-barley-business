<?php

session_start();

require "../config/database.php";

$message=trim($_POST['message']);

$conversation=$_SESSION['conversation_id'];

$stmt=$conn->prepare("
INSERT INTO conversation_messages
(conversation_id,sender,message)
VALUES
(:conversation,'Customer',:message)
");

$stmt->execute([

":conversation"=>$conversation,

":message"=>$message

]);

echo "OK";