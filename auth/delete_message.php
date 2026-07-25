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

/*
|--------------------------------------------------------------------------
| Delete Message (Owner Only)
|--------------------------------------------------------------------------
*/

$stmt = $conn->prepare("
    DELETE FROM contact_messages
    WHERE id = :id
    AND owner_id = :owner_id
");

$stmt->execute([
    ':id' => $id,
    ':owner_id' => $_SESSION['user_id']
]);

header("Location: ../dashboard/messages/index.php");
exit;