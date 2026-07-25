<?php

require '../config/session.php';
require '../config/database.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit;
}

if (!isset($_GET['id'])) {
    die("Achievement ID is missing.");
}

$id = $_GET['id'];

// Kunin muna ang image
$stmt = $conn->prepare("
    SELECT image
    FROM achievements
    WHERE id = :id
    AND owner_id = :owner_id
");

$stmt->execute([
    ':id' => $id,
    ':owner_id' => $_SESSION['user_id']
]);

$achievement = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$achievement) {
    die("Achievement not found.");
}

// Burahin ang image file
if (
    !empty($achievement['image']) &&
    file_exists("../uploads/achievements/" . $achievement['image'])
) {
    unlink("../uploads/achievements/" . $achievement['image']);
}

// Burahin ang record
$delete = $conn->prepare("
    DELETE FROM achievements
    WHERE id = :id
    AND owner_id = :owner_id
");

$delete->execute([
    ':id' => $id,
    ':owner_id' => $_SESSION['user_id']
]);

header("Location: ../dashboard/achievements/index.php");
exit;