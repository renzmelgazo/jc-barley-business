<?php

require '../config/session.php';
require '../config/database.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $login = trim($_POST['login']);
    $password = $_POST['password'];

    $stmt = $conn->prepare("
        SELECT *
        FROM users
        WHERE username = :login
        OR email = :login
        LIMIT 1
    ");

    $stmt->execute([
        ':login' => $login
    ]);

    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        die("Invalid username or email.");
    }

    if (!password_verify($password, $user['password'])) {
        die("Incorrect password.");
    }

    if ($user['status'] !== 'active') {
        die("Your account is inactive.");
    }

    $_SESSION['user_id'] = $user['id'];
    $_SESSION['fullname'] = $user['fullname'];
    $_SESSION['username'] = $user['username'];
    $_SESSION['email'] = $user['email'];

    header("Location: ../dashboard/index.php");
exit;
}