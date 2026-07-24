<?php

require '../config/session.php';
require '../config/database.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    header("Location: ../dashboard/gallery/index.php");
    exit;
}

$id = $_POST['id'];
$title = trim($_POST['title']);
$description = trim($_POST['description']);
$oldImage = $_POST['old_image'];

$imageName = $oldImage;

/*
|--------------------------------------------------------------------------
| Upload New Image (Optional)
|--------------------------------------------------------------------------
*/

if (
    isset($_FILES['image']) &&
    $_FILES['image']['error'] == 0
) {

    $allowed = ['jpg','jpeg','png','webp'];

    $extension = strtolower(
        pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION)
    );

    if (!in_array($extension, $allowed)) {
        die("Invalid image format.");
    }

    $imageName = uniqid() . "." . $extension;

    move_uploaded_file(
        $_FILES['image']['tmp_name'],
        "../uploads/gallery/" . $imageName
    );

    if (
        !empty($oldImage) &&
        file_exists("../uploads/gallery/" . $oldImage)
    ) {
        unlink("../uploads/gallery/" . $oldImage);
    }

}

/*
|--------------------------------------------------------------------------
| Update Database
|--------------------------------------------------------------------------
*/

$stmt = $conn->prepare("
UPDATE gallery
SET

title = :title,
description = :description,
image = :image

WHERE id = :id
");

$stmt->execute([

':title' => $title,
':description' => $description,
':image' => $imageName,
':id' => $id

]);

header("Location: ../dashboard/gallery/index.php");
exit;