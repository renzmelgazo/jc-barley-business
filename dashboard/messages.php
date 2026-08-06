<?php

require '../config/session.php';
require '../config/database.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit;
}

$stmt = $conn->prepare("
SELECT *
FROM chat_conversations
WHERE owner_id = :owner
ORDER BY id DESC
");

$stmt->execute([
    ':owner' => $_SESSION['user_id']
]);

$conversations = $stmt->fetchAll(PDO::FETCH_ASSOC);

$pageTitle = "Messages";

include '../includes/header.php';
include '../includes/sidebar.php';
include '../includes/navbar.php';

?>

<div class="main-content">

<div class="content">

<h2 class="mb-4 fw-bold">
💬 Messages
</h2>

<div class="card shadow">

<div class="list-group list-group-flush">

<?php foreach($conversations as $chat): ?>

<a
href="conversation.php?id=<?= $chat['id'] ?>"
class="list-group-item list-group-item-action">

<strong>

<?= $chat['visitor_name'] ?: "Unknown Visitor" ?>

</strong>

<br>

<small>

<?= $chat['status'] ?>

</small>

</a>

<?php endforeach; ?>

</div>

</div>

</div>

</div>

<?php include '../includes/footer.php'; ?>