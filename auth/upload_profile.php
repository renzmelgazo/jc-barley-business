<?php

require '../config/session.php';
require '../config/database.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: ../dashboard/profile.php");
    exit;
}

if (!isset($_FILES['profile_picture'])) {
    $_SESSION['error'] = "Please select an image first.";
header("Location: ../dashboard/profile.php");
exit;
}

$file = $_FILES['profile_picture'];

if ($file['error'] !== UPLOAD_ERR_OK) {
    $_SESSION['error'] = "Upload failed. Please try again.";
header("Location: ../dashboard/profile.php");
exit;
}

$allowedTypes = [
    'image/jpeg' => 'jpg',
    'image/png'  => 'png',
    'image/webp' => 'webp'
];

$finfo = finfo_open(FILEINFO_MIME_TYPE);
$mime = finfo_file($finfo, $file['tmp_name']);
finfo_close($finfo);

if (!isset($allowedTypes[$mime])) {
    $_SESSION['error'] = "Only JPG, PNG and WEBP images are allowed.";
header("Location: ../dashboard/profile.php");
exit;
}

if ($file['size'] > 2 * 1024 * 1024) {
    $_SESSION['error'] = "Image is too large. Maximum file size is 2MB.";
header("Location: ../dashboard/profile.php");
exit;
}

$extension = $allowedTypes[$mime];
$filename = uniqid('profile_', true) . "." . $extension;

$uploadDir = "../uploads/profiles/";

if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0777, true);
}

$destination = $uploadDir . $filename;

if (!move_uploaded_file($file['tmp_name'], $destination)) {
    $_SESSION['error'] = "Failed to save the uploaded image.";
header("Location: ../dashboard/profile.php");
exit;
}

/*
|--------------------------------------------------------------------------
| Get Old Profile Picture
|--------------------------------------------------------------------------
*/

$stmt = $conn->prepare("
    SELECT profile_picture
    FROM users
    WHERE id = :id
");

$stmt->execute([
    ':id' => $_SESSION['user_id']
]);

$user = $stmt->fetch(PDO::FETCH_ASSOC);

/*
|--------------------------------------------------------------------------
| Delete Old Profile Picture
|--------------------------------------------------------------------------
*/

if (
    !empty($user['profile_picture']) &&
    file_exists("../uploads/profiles/" . $user['profile_picture'])
) {
    unlink("../uploads/profiles/" . $user['profile_picture']);
}

/*
|--------------------------------------------------------------------------
| Update Database
|--------------------------------------------------------------------------
*/

$stmt = $conn->prepare("
    UPDATE users
    SET
        profile_picture = :picture,
        updated_at = NOW()
    WHERE id = :id
");

$stmt->execute([
    ':picture' => $filename,
    ':id' => $_SESSION['user_id']
]);

$_SESSION['profile_picture'] = $filename;

$_SESSION['success'] = "Profile picture updated successfully.";

header("Location: ../dashboard/profile.php");
exit;