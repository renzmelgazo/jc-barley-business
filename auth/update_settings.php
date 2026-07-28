<?php

require '../config/session.php';
require '../config/database.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    header("Location: ../dashboard/settings.php");
    exit;
}

$fullname = trim($_POST['fullname']);
$username = trim($_POST['username']);
$email = trim($_POST['email']);

$stmt = $conn->prepare("
    UPDATE users
    SET
        fullname = :fullname,
        username = :username,
        email = :email,
        updated_at = NOW()
    WHERE id = :id
");

$stmt->execute([
    ':fullname' => $fullname,
    ':username' => $username,
    ':email' => $email,
    ':id' => $_SESSION['user_id']
]);

// Update Session
$_SESSION['fullname'] = $fullname;
$_SESSION['username'] = $username;
$_SESSION['email'] = $email;

$_SESSION['success'] = "Settings updated successfully.";

header("Location: ../dashboard/settings.php");
exit;