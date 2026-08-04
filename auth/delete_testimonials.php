<?php

require '../config/session.php';
require '../config/database.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit;
}

if (!isset($_GET['id'])) {
    die("Invalid request.");
}

$id = (int)$_GET['id'];

$stmt = $conn->prepare("
DELETE FROM testimonials
WHERE id = :id
AND owner_id = :owner
");

$stmt->execute([

':id'=>$id,
':owner'=>$_SESSION['user_id']

]);

header("Location: ../dashboard/testimonials/index.php");
exit;