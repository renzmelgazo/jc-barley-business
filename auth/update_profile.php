<?php

require '../config/session.php';
require '../config/database.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $fullname = trim($_POST['fullname']);
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);

    if (
        empty($fullname) ||
        empty($username) ||
        empty($email)
    ) {
        die("All fields are required.");
    }

    // Check if username or email is already used by another account
    $check = $conn->prepare("
        SELECT id
        FROM users
        WHERE
            (username = :username OR email = :email)
            AND id != :id
    ");

    $check->execute([
        ':username' => $username,
        ':email' => $email,
        ':id' => $_SESSION['user_id']
    ]);

    if ($check->rowCount() > 0) {
        die("Username or Email already exists.");
    }

    // Update user
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

    $_SESSION['profile_picture'] = $filename;
$_SESSION['success'] = "Profile picture updated successfully.";

    // Update session values
    $_SESSION['fullname'] = $fullname;
    $_SESSION['username'] = $username;
    $_SESSION['email'] = $email;

    header("Location: ../dashboard/profile.php");
    exit;
}