<?php

require '../config/session.php';
require '../config/database.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit;
}

$pageTitle = "Settings";
include '../includes/header.php';
?>

<?php include '../includes/sidebar.php'; ?>

<div class="main-content">

    <?php include '../includes/navbar.php'; ?>

    <div class="content">

        <div class="dashboard-card">

            <h2 class="fw-bold text-success mb-4">

                <i class="bi bi-gear-fill"></i>

                Settings

            </h2>

            <div class="alert alert-info">

                <h5 class="mb-2">

                    🚧 Coming Soon

                </h5>

                <p class="mb-0">

                    This page will contain:

                </p>

                <ul class="mt-3 mb-0">

                    <li>Change Password</li>

                    <li>Two-Factor Authentication</li>

                    <li>Email Notifications</li>

                    <li>Account Preferences</li>

                    <li>Security Settings</li>

                </ul>

            </div>

        </div>

    </div>

</div>

<?php include '../includes/footer.php'; ?>