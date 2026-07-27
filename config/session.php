<?php

// Start session only if it hasn't started yet
if (session_status() === PHP_SESSION_NONE) {
    session_start();
    /*
|--------------------------------------------------------------------------
| Remember Me Auto Login
|--------------------------------------------------------------------------
*/

if (!isset($_SESSION['user_id']) && isset($_COOKIE['remember'])) {

    require_once __DIR__ . '/database.php';

    list($selector, $token) = explode(':', $_COOKIE['remember'], 2);

    $stmt = $conn->prepare("
        SELECT *
        FROM remember_tokens
        WHERE selector = :selector
        LIMIT 1
    ");

    $stmt->execute([
        ':selector' => $selector
    ]);

    $remember = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($remember) {

        if (
            strtotime($remember['expires_at']) > time() &&
            password_verify($token, $remember['hashed_token'])
        ) {

            $stmt = $conn->prepare("
                SELECT *
                FROM users
                WHERE id = :id
                LIMIT 1
            ");

            $stmt->execute([
                ':id' => $remember['user_id']
            ]);

            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user) {

                $_SESSION['user_id'] = $user['id'];
                $_SESSION['fullname'] = $user['fullname'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['email'] = $user['email'];

            }

        }

    }

}
}