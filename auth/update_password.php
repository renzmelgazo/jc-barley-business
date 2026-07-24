<?php

require '../config/session.php';
require '../config/database.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $currentPassword = $_POST['current_password'];
    $newPassword = $_POST['new_password'];
    $confirmPassword = $_POST['confirm_password'];

    // Check if new passwords match
    if ($newPassword !== $confirmPassword) {
        die("New passwords do not match.");
    }

    // Get current user
    $stmt = $conn->prepare("
        SELECT password
        FROM users
        WHERE id = :id
    ");

    $stmt->execute([
        ':id' => $_SESSION['user_id']
    ]);

    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        die("User not found.");
    }

    // Verify current password
    if (!password_verify($currentPassword, $user['password'])) {
        die("Current password is incorrect.");
    }

    // Hash new password
    $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

    // Update password
    $update = $conn->prepare("
        UPDATE users
        SET
            password = :password,
            updated_at = NOW()
        WHERE id = :id
    ");

    $update->execute([
        ':password' => $hashedPassword,
        ':id' => $_SESSION['user_id']
    ]);

    header("Location: ../dashboard/profile.php");
    exit;
}