<?php

require '../config/session.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit;
}

include '../includes/header.php';
include '../includes/navbar.php';
?>

<div class="d-flex">

<?php include '../includes/sidebar.php'; ?>

<div class="container-fluid p-4">

<h2>Dashboard</h2>

<p>Welcome back,
<strong><?= htmlspecialchars($_SESSION['fullname']) ?></strong>

</p>

</div>

</div>

<?php include '../includes/footer.php'; ?>