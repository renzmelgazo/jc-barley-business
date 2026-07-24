<?php

require '../config/session.php';
require '../config/database.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit;
}

$stmt = $conn->prepare("SELECT * FROM users WHERE id = :id");
$stmt->execute([
    ':id' => $_SESSION['user_id']
]);

$user = $stmt->fetch(PDO::FETCH_ASSOC);

include '../includes/header.php';
include '../includes/navbar.php';
?>

<div class="d-flex">

<?php include '../includes/sidebar.php'; ?>

<div class="container-fluid p-4">

    <h2>My Profile</h2>

    <div class="card mt-3" style="max-width:700px;">

        <div class="card-body">

            <div class="text-center">

                <img
                    src="../uploads/profiles/<?=
                        htmlspecialchars($user['profile_picture'])
                    ?>"
                    width="150"
                    height="150"
                    class="rounded-circle border">

            </div>

            <hr>

            <p><strong>Full Name:</strong> <?= htmlspecialchars($user['fullname']) ?></p>

            <p><strong>Username:</strong> <?= htmlspecialchars($user['username']) ?></p>

            <p><strong>Email:</strong> <?= htmlspecialchars($user['email']) ?></p>

            <p><strong>Status:</strong> <?= htmlspecialchars($user['status']) ?></p>

            <p><strong>Theme:</strong> <?= htmlspecialchars($user['theme']) ?></p>

        </div>

    </div>

</div>

</div>

<?php include '../includes/footer.php'; ?>