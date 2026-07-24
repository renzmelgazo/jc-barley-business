<?php

require '../config/database.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $fullname = trim($_POST['fullname']);
    $username = trim($_POST['username']);
    $email    = trim($_POST['email']);
    $password = $_POST['password'];

    // Check required fields
    if (
        empty($fullname) ||
        empty($username) ||
        empty($email) ||
        empty($password)
    ) {
        die("Please fill in all fields.");
    }

    // Check if username or email already exists
    $check = $conn->prepare("
        SELECT id
        FROM users
        WHERE username = :username
        OR email = :email
    ");

    $check->execute([
        ':username' => $username,
        ':email' => $email
    ]);

    if ($check->rowCount() > 0) {
        die("Username or Email already exists.");
    }

    // Hash password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Default values
    $profile_picture = "default.png";
    $theme = "light";
    $status = "active";

    // Generate site slug
$site_slug = "jcbarley" . strtolower($username);

    // Insert user
    $stmt = $conn->prepare("
        INSERT INTO users
(
    fullname,
    username,
    site_slug,
    email,
    password,
    profile_picture,
    theme,
    status,
    created_at,
    updated_at
)
VALUES
(
    :fullname,
    :username,
    :site_slug,
    :email,
    :password,
    :profile_picture,
    :theme,
    :status,
    NOW(),
    NOW()
)
    ");

    $stmt->execute([
    ':fullname' => $fullname,
    ':username' => $username,
    ':site_slug' => $site_slug,
    ':email' => $email,
        ':password' => $hashedPassword,
        ':profile_picture' => $profile_picture,
        ':theme' => $theme,
        ':status' => $status
    ]);

    header("Location: ../login.php?registered=1");
    exit;
}