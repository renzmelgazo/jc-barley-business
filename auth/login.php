<?php

require '../config/session.php';
require '../config/database.php';
require '../config/remember.php';

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

/*
|--------------------------------------------------------------------------
| User Not Found
|--------------------------------------------------------------------------
*/

if (!$user) {

    header("Location: ../login.php?error=invalid&login=" . urlencode($login));

    exit;

}

/*
|--------------------------------------------------------------------------
| Wrong Password
|--------------------------------------------------------------------------
*/

if (!password_verify($password, $user['password'])) {

    header("Location: ../login.php?error=invalid&login=" . urlencode($login));

    exit;

}
    if ($user['status'] !== 'active') {
        die("Your account is inactive.");
    }

    /*
|--------------------------------------------------------------------------
| Login Session
|--------------------------------------------------------------------------
*/

$_SESSION['user_id'] = $user['id'];
$_SESSION['fullname'] = $user['fullname'];
$_SESSION['username'] = $user['username'];
$_SESSION['email'] = $user['email'];
$_SESSION['profile_picture'] = $user['profile_picture'];

/*
|--------------------------------------------------------------------------
| Remember Me
|--------------------------------------------------------------------------
*/

if (isset($_POST['remember'])) {

    $selector = generateSelector();
    $token = generateRememberToken();

    $hashedToken = password_hash($token, PASSWORD_DEFAULT);

    $expires = date(
        'Y-m-d H:i:s',
        strtotime('+30 days')
    );

    $stmt = $conn->prepare("
        INSERT INTO remember_tokens
        (
            user_id,
            selector,
            hashed_token,
            expires_at
        )
        VALUES
        (
            :user_id,
            :selector,
            :hashed_token,
            :expires_at
        )
    ");

    $stmt->execute([

        ':user_id' => $user['id'],

        ':selector' => $selector,

        ':hashed_token' => $hashedToken,

        ':expires_at' => $expires

    ]);

    setcookie(

        "remember",

        $selector . ":" . $token,

        time() + (60 * 60 * 24 * 30),

        "/",

        "",

        false,

        true

    );

}

header("Location: ../dashboard/index.php");
exit;
}