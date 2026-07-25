<?php

require '../config/session.php';
require '../config/database.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] != "POST") {
    header("Location: ../dashboard/gallery/index.php");
    exit;
}

$title = trim($_POST['title']);
$description = trim($_POST['description']);

if (empty($title)) {
    die("Title is required.");
}

if (!isset($_FILES['image']) || $_FILES['image']['error'] != 0) {
    die("Please select an image.");
}

$allowed = ['jpg', 'jpeg', 'png', 'webp'];

$filename = $_FILES['image']['name'];
$tmp = $_FILES['image']['tmp_name'];

$extension = strtolower(pathinfo($filename, PATHINFO_EXTENSION));

if (!in_array($extension, $allowed)) {
    die("Invalid image format.");
}

$newFilename = uniqid() . "." . $extension;

$destination = "../uploads/gallery/" . $newFilename;

if (!move_uploaded_file($tmp, $destination)) {
    die("Failed to upload image.");
}

$stmt = $conn->prepare("
    INSERT INTO gallery
(
    owner_id,
    title,
    description,
    image
)
    VALUES
(
    :owner_id,
    :title,
    :description,
    :image
)
");

$stmt->execute([
    ':owner_id' => $_SESSION['user_id'],
    ':title' => $title,
    ':description' => $description,
    ':image' => $newFilename
]);

header("Location: ../dashboard/gallery/index.php");
exit;