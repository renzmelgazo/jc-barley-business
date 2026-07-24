<?php

require '../config/session.php';
require '../config/database.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit;
}

if (!isset($_GET['id'])) {
    header("Location: ../dashboard/messages/index.php");
    exit;
}

$id = (int) $_GET['id'];

$stmt = $conn->prepare("
    DELETE FROM contact_messages
    WHERE id = :id
");

$stmt->execute([
    ':id' => $id
]);

header("Location: ../dashboard/messages/index.php");
exit;