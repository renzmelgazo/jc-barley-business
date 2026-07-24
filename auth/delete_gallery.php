<?php

require '../config/session.php';
require '../config/database.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit;
}

if (!isset($_GET['id'])) {
    header("Location: ../dashboard/gallery/index.php");
    exit;
}

$id = (int) $_GET['id'];

/*
|--------------------------------------------------------------------------
| Kunin muna ang image filename
|--------------------------------------------------------------------------
*/

$stmt = $conn->prepare("
    SELECT image
    FROM gallery
    WHERE id = :id
");

$stmt->execute([
    ':id' => $id
]);

$gallery = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$gallery) {
    die("Gallery image not found.");
}

/*
|--------------------------------------------------------------------------
| Delete image file
|--------------------------------------------------------------------------
*/

$imagePath = "../uploads/gallery/" . $gallery['image'];

if (file_exists($imagePath)) {
    unlink($imagePath);
}

/*
|--------------------------------------------------------------------------
| Delete record
|--------------------------------------------------------------------------
*/

$stmt = $conn->prepare("
    DELETE FROM gallery
    WHERE id = :id
");

$stmt->execute([
    ':id' => $id
]);

header("Location: ../dashboard/gallery/index.php");
exit;