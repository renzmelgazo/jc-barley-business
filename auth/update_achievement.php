<?php

require '../config/session.php';
require '../config/database.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $id = $_POST['id'];
    $title = trim($_POST['title']);
    $description = trim($_POST['description']);
    $award_date = $_POST['award_date'];
    $oldImage = $_POST['old_image'];

    if (
        empty($title) ||
        empty($description) ||
        empty($award_date)
    ) {
        die("All fields are required.");
    }

    $image = $oldImage;

    // Check if a new image was uploaded
    if (!empty($_FILES['image']['name'])) {

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

        // Delete old image
        if (
            !empty($oldImage) &&
            file_exists("../uploads/achievements/" . $oldImage)
        ) {
            unlink("../uploads/achievements/" . $oldImage);
        }

        $image = $filename;
    }

    $stmt = $conn->prepare("
    UPDATE achievements
    SET
        title = :title,
        description = :description,
        image = :image,
        award_date = :award_date,
        updated_at = NOW()
    WHERE id = :id
    AND owner_id = :owner_id
");

    $stmt->execute([
    ':title' => $title,
    ':description' => $description,
    ':image' => $image,
    ':award_date' => $award_date,
    ':id' => $id,
    ':owner_id' => $_SESSION['user_id']
]);

    header("Location: ../dashboard/achievements/index.php");
    exit;
}