<?php

require '../config/session.php';
require '../config/database.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit;
}

$id = (int)$_POST['id'];
$owner = $_SESSION['user_id'];

$fullname = trim($_POST['fullname']);
$position = trim($_POST['position']);
$message = trim($_POST['message']);

$image = $_POST['old_image'];

$uploadDir = "../uploads/testimonials/";

if (
    isset($_FILES['image']) &&
    $_FILES['image']['error'] == 0
) {

    $ext = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));

    $image = uniqid() . "." . $ext;

    move_uploaded_file(
        $_FILES['image']['tmp_name'],
        $uploadDir . $image
    );
}

$stmt = $conn->prepare("
UPDATE testimonials
SET

fullname = :fullname,
position = :position,
message = :message,
image = :image

WHERE id = :id
AND owner_id = :owner
");

$stmt->execute([

    ':fullname' => $fullname,
    ':position' => $position,
    ':message' => $message,
    ':image'    => $image,

    ':id'       => $id,
    ':owner'    => $owner

]);

header("Location: ../dashboard/testimonials/index.php?updated=1");
exit;