<?php

require '../config/database.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: ../login.php");
    exit;
}

$token = $_POST['token'] ?? '';
$password = $_POST['password'] ?? '';
$confirm = $_POST['confirm_password'] ?? '';

if (empty($token) || empty($password) || empty($confirm)) {
    die("Please complete all fields.");
}

if ($password !== $confirm) {
    
    if (strlen($password) < 8) {

    die("Password must be at least 8 characters.");

}
    die("Passwords do not match.");
}

/*
|--------------------------------------------------------------------------
| Find Valid Token
|--------------------------------------------------------------------------
*/

$stmt = $conn->query("
    SELECT *
    FROM password_resets
");

$reset = null;

while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

    if (
        password_verify($token, $row['token'])
    ) {

        $reset = $row;

        break;

    }

}

if (!$reset) {

    die("Invalid reset link.");

}

if (
    strtotime($reset['expires_at']) < time()
) {

    die("Reset link expired.");

}

/*
|--------------------------------------------------------------------------
| Update Password
|--------------------------------------------------------------------------
*/

$hash = password_hash(
    $password,
    PASSWORD_DEFAULT
);

$update = $conn->prepare("
    UPDATE users
    SET password = :password
    WHERE id = :id
");

$update->execute([

    ':password' => $hash,

    ':id' => $reset['user_id']

]);

/*
|--------------------------------------------------------------------------
| Delete Token
|--------------------------------------------------------------------------
*/

$delete = $conn->prepare("
    DELETE FROM password_resets
    WHERE id = :id
");

$delete->execute([

    ':id' => $reset['id']

]);

header("Location: ../login.php?password_reset=1");

exit;