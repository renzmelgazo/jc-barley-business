<?php

require '../config/database.php';

if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    header("Location: ../contact.php");
    exit;
}

$fullname = trim($_POST['fullname']);
$email = trim($_POST['email']);
$subject = trim($_POST['subject']);
$message = trim($_POST['message']);

if (
    empty($fullname) ||
    empty($email) ||
    empty($subject) ||
    empty($message)
) {
    die("All fields are required.");
}

$stmt = $conn->prepare("
    INSERT INTO contact_messages
    (
        fullname,
        email,
        subject,
        message
    )
    VALUES
    (
        :fullname,
        :email,
        :subject,
        :message
    )
");

$stmt->execute([

    ':fullname' => $fullname,
    ':email' => $email,
    ':subject' => $subject,
    ':message' => $message

]);

header("Location: ../contact.php?success=1");
exit;