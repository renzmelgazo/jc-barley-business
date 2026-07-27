<?php

require '../config/database.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: ../forgot-password.php");
    exit;
}

$email = trim($_POST['email']);

if (empty($email)) {
    header("Location: ../forgot-password.php?error=empty");
    exit;
}

/*
|--------------------------------------------------------------------------
| Find User
|--------------------------------------------------------------------------
*/

$stmt = $conn->prepare("
    SELECT id, fullname, email
    FROM users
    WHERE email = :email
    LIMIT 1
");

$stmt->execute([
    ':email' => $email
]);

$user = $stmt->fetch(PDO::FETCH_ASSOC);

/*
|--------------------------------------------------------------------------
| Don't reveal if email exists
|--------------------------------------------------------------------------
*/

if (!$user) {

    header("Location: ../forgot-password.php?success=1");

    exit;

}

/*
|--------------------------------------------------------------------------
| Generate Secure Token
|--------------------------------------------------------------------------
*/

$token = bin2hex(random_bytes(32));

$expiresAt = date(
    'Y-m-d H:i:s',
    strtotime('+1 hour')
);

/*
|--------------------------------------------------------------------------
| Delete Old Reset Token
|--------------------------------------------------------------------------
*/

$delete = $conn->prepare("
    DELETE FROM password_resets
    WHERE user_id = :user_id
");

$delete->execute([
    ':user_id' => $user['id']
]);

/*
|--------------------------------------------------------------------------
| Save New Reset Token
|--------------------------------------------------------------------------
*/

$insert = $conn->prepare("
    INSERT INTO password_resets
    (
        user_id,
        token,
        expires_at
    )
    VALUES
    (
        :user_id,
        :token,
        :expires_at
    )
");

$insert->execute([

    ':user_id' => $user['id'],

    ':token' => password_hash($token, PASSWORD_DEFAULT),

    ':expires_at' => $expiresAt

]);

require_once '../config/mailer.php';

try {

    $mail = getMailer();

    $mail->addAddress(
        $user['email'],
        $user['fullname']
    );

    $resetLink =
        "http://localhost:8888/jc-barley-website/reset-password.php?token=" .
        urlencode($token);

    $mail->Subject = "Reset Your Password";

    $mail->Body = "

    <div style='font-family:Arial,sans-serif;padding:30px;'>

        <h2 style='color:#198754;'>

            JC Barley Website

        </h2>

        <p>

            Hello <strong>{$user['fullname']}</strong>,

        </p>

        <p>

            We received a request to reset your password.

        </p>

        <p>

            Click the button below to create a new password.

        </p>

        <p style='margin:30px 0;'>

            <a href='{$resetLink}'

               style='background:#198754;
                      color:#fff;
                      padding:14px 28px;
                      text-decoration:none;
                      border-radius:8px;
                      display:inline-block;'>

                Reset Password

            </a>

        </p>

        <p>

            This link will expire in <strong>1 hour</strong>.

        </p>

        <p>

            If you didn't request this,
            simply ignore this email.

        </p>

        <hr>

        <small>

            © JC Barley Website

        </small>

    </div>

    ";

    $mail->send();

} catch (Exception $e) {

    die("Mailer Error: " . $mail->ErrorInfo);

}

header("Location: ../forgot-password.php?success=1");

exit;