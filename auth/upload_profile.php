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
    die("No file uploaded.");
}

$file = $_FILES['profile_picture'];

if ($file['error'] !== UPLOAD_ERR_OK) {
    die("Upload failed.");
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
    die("Only JPG, PNG and WEBP files are allowed.");
}

if ($file['size'] > 2 * 1024 * 1024) {
    die("Maximum file size is 2MB.");
}

$extension = $allowedTypes[$mime];
$filename = uniqid('profile_', true) . "." . $extension;

$uploadDir = "../uploads/profiles/";

if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0777, true);
}

$destination = $uploadDir . $filename;

if (!move_uploaded_file($file['tmp_name'], $destination)) {
    die("Failed to save uploaded file.");
}

$stmt = $conn->prepare("
    UPDATE users
    SET profile_picture = :picture
    WHERE id = :id
");

$stmt->execute([
    ':picture' => $filename,
    ':id' => $_SESSION['user_id']
]);

header("Location: ../dashboard/profile.php");
exit;