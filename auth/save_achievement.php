<?php

require '../config/session.php';
require '../config/database.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $title = trim($_POST['title']);
    $description = trim($_POST['description']);
    $award_date = $_POST['award_date'];

    if (
        empty($title) ||
        empty($description) ||
        empty($award_date)
    ) {
        die("All fields are required.");
    }

    if (!isset($_FILES['image']) || $_FILES['image']['error'] != 0) {
        die("Please select an image.");
    }

    $allowed = ['jpg', 'jpeg', 'png', 'webp'];

    $extension = strtolower(pathinfo(
        $_FILES['image']['name'],
        PATHINFO_EXTENSION
    ));

    if (!in_array($extension, $allowed)) {
        die("Invalid image format.");
    }

    $filename = time() . "_" . uniqid() . "." . $extension;

    $destination = "../uploads/achievements/" . $filename;

    if (!move_uploaded_file($_FILES['image']['tmp_name'], $destination)) {
        die("Image upload failed.");
    }

    $stmt = $conn->prepare("
        INSERT INTO achievements
(
    owner_id,
    title,
    description,
    image,
    award_date
)
        VALUES
(
    :owner_id,
    :title,
    :description,
    :image,
    :award_date
)
    ");

    $stmt->execute([
    ':owner_id' => $_SESSION['user_id'],
    ':title' => $title,
    ':description' => $description,
    ':image' => $filename,
    ':award_date' => $award_date
]);

    header("Location: ../dashboard/achievements/index.php");
    exit;
}