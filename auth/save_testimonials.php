<?php

require '../config/session.php';
require '../config/database.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit;
}

$ownerId = $_SESSION['user_id'];

$fullname = trim($_POST['fullname']);
$position = trim($_POST['position']);
$message = trim($_POST['message']);

$image = "";

/*
|--------------------------------------------------------------------------
| Upload Folder
|--------------------------------------------------------------------------
*/

$uploadDir = "../uploads/testimonials/";

if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0777, true);
}

/*
|--------------------------------------------------------------------------
| Upload Image
|--------------------------------------------------------------------------
*/

if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {

    $extension = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));

    $image = uniqid("testimonial_") . "." . $extension;

    move_uploaded_file(
        $_FILES['image']['tmp_name'],
        $uploadDir . $image
    );
}

/*
|--------------------------------------------------------------------------
| Save Database
|--------------------------------------------------------------------------
*/

$stmt = $conn->prepare("
INSERT INTO testimonials
(
owner_id,
fullname,
position,
message,
image
)

VALUES
(
:owner_id,
:fullname,
:position,
:message,
:image
)
");

$stmt->execute([

':owner_id' => $ownerId,
':fullname' => $fullname,
':position' => $position,
':message' => $message,
':image' => $image

]);

header("Location: ../dashboard/testimonials/index.php?success=1");
exit;