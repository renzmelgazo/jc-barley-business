<?php

require '../../config/session.php';
require '../../config/database.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../../login.php");
    exit;
}

if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit;
}

$id = (int) $_GET['id'];

/*
|--------------------------------------------------------------------------
| Mark message as Read (Owner Only)
|--------------------------------------------------------------------------
*/

$stmt = $conn->prepare("
    UPDATE contact_messages
    SET status = 'Read'
    WHERE id = :id
    AND owner_id = :owner_id
");

$stmt->execute([
    ':id' => $id,
    ':owner_id' => $_SESSION['user_id']
]);

/*
|--------------------------------------------------------------------------
| Get Message (Owner Only)
|--------------------------------------------------------------------------
*/

$stmt = $conn->prepare("
    SELECT *
    FROM contact_messages
    WHERE id = :id
    AND owner_id = :owner_id
");

$stmt->execute([
    ':id' => $id,
    ':owner_id' => $_SESSION['user_id']
]);

$message = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$message) {
    die("Message not found.");
}

$pageTitle = "View Message";

include '../../includes/header.php';
include '../../includes/sidebar.php';
?>

<div class="main-content">

<?php include '../../includes/navbar.php'; ?>

<div class="content">

<h2 class="fw-bold mb-4">

<i class="bi bi-envelope-open me-2 text-success"></i>

View Message

</h2>

<h2 class="mb-4">View Message</h2>

<div class="card shadow">

<div class="card-body">

<table class="table">

<tr>
<th width="180">Full Name</th>
<td><?= htmlspecialchars($message['fullname']) ?></td>
</tr>

<tr>
<th>Email</th>
<td><?= htmlspecialchars($message['email']) ?></td>
</tr>

<tr>
<th>Subject</th>
<td><?= htmlspecialchars($message['subject']) ?></td>
</tr>

<tr>
<th>Status</th>
<td>
<span class="badge bg-success">
<?= htmlspecialchars($message['status']) ?>
</span>
</td>
</tr>

<tr>
<th>Date</th>
<td><?= date('F d, Y h:i A', strtotime($message['created_at'])) ?></td>
</tr>

<tr>
<th>Message</th>
<td><?= nl2br(htmlspecialchars($message['message'])) ?></td>
</tr>

</table>

<a
href="index.php"
class="btn btn-secondary">

Back to Inbox

</a>

</div>

</div>

</div>

</div>

<?php include '../../includes/footer.php'; ?>