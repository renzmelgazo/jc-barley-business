<?php

require '../config/database.php';

if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    header("Location: ../index.php");
    exit;
}

$owner_id = (int) $_POST['owner_id'];

$fullname = trim($_POST['fullname']);
$email = trim($_POST['email']);
$subject = trim($_POST['subject']);
$message = trim($_POST['message']);

if (
    empty($owner_id) ||
    empty($fullname) ||
    empty($email) ||
    empty($subject) ||
    empty($message)
) {
    die("All fields are required.");
}

/*
|--------------------------------------------------------------------------
| Save Message
|--------------------------------------------------------------------------
*/

$stmt = $conn->prepare("
    INSERT INTO contact_messages
    (
        owner_id,
        fullname,
        email,
        subject,
        message
    )
    VALUES
    (
        :owner_id,
        :fullname,
        :email,
        :subject,
        :message
    )
");

$stmt->execute([

    ':owner_id' => $owner_id,
    ':fullname' => $fullname,
    ':email' => $email,
    ':subject' => $subject,
    ':message' => $message

]);

header("Location: ../site.php?owner=" . urlencode($_GET['owner'] ?? '') . "&success=1");
exit;