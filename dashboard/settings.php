<?php

require '../config/session.php';
require '../config/database.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit;
}

$stmt = $conn->prepare("
    SELECT *
    FROM users
    WHERE id = :id
");

$stmt->execute([
    ':id' => $_SESSION['user_id']
]);

$user = $stmt->fetch(PDO::FETCH_ASSOC);

$pageTitle = "Settings";

include '../includes/header.php';
include '../includes/sidebar.php';
?>

<div class="main-content">

<?php include '../includes/navbar.php'; ?>

<div class="content">

<?php if(isset($_SESSION['success'])): ?>

<div class="alert alert-success alert-dismissible fade show mb-4">

    <i class="bi bi-check-circle-fill me-2"></i>

    <?= $_SESSION['success']; ?>

    <button
        type="button"
        class="btn-close"
        data-bs-dismiss="alert">
    </button>

</div>

<?php unset($_SESSION['success']); ?>

<?php endif; ?>


<?php if(isset($_SESSION['error'])): ?>

<div class="alert alert-danger alert-dismissible fade show mb-4">

    <i class="bi bi-exclamation-triangle-fill me-2"></i>

    <?= $_SESSION['error']; ?>

    <button
        type="button"
        class="btn-close"
        data-bs-dismiss="alert">
    </button>

</div>

<?php unset($_SESSION['error']); ?>

<?php endif; ?>

    <h2 class="fw-bold mb-4">

        <i class="bi bi-gear-fill text-success"></i>

        Settings

    </h2>

    <div class="card shadow border-0">

        <div class="card-body p-4">

            <form action="../auth/update_settings.php" method="POST">

                <h4 class="mb-4">

                    Personal Information

                </h4>

                <div class="mb-3">

                    <label class="form-label">

                        Full Name

                    </label>

                    <input
                        type="text"
                        name="fullname"
                        class="form-control"
                        value="<?= htmlspecialchars($user['fullname']) ?>">

                </div>

                <div class="mb-3">

                    <label class="form-label">

                        Username

                    </label>

                    <input
                        type="text"
                        name="username"
                        class="form-control"
                        value="<?= htmlspecialchars($user['username']) ?>">

                </div>

                <div class="mb-4">

                    <label class="form-label">

                        Email

                    </label>

                    <input
                        type="email"
                        name="email"
                        class="form-control"
                        value="<?= htmlspecialchars($user['email']) ?>">

                </div>

                <button
                    class="btn btn-success">

                    Save Changes

                </button>

            </form>

        </div>

    </div>

    <br>

    <div class="card shadow border-0">

        <div class="card-body p-4">

            <h4 class="mb-4">

                Change Password

            </h4>

            <form action="../auth/change_password.php" method="POST">

                <div class="mb-3">

                    <label>

                        Current Password

                    </label>

                    <input
                        type="password"
                        name="current_password"
                        class="form-control">

                </div>

                <div class="mb-3">

                    <label>

                        New Password

                    </label>

                    <input
                        type="password"
                        name="new_password"
                        class="form-control">

                </div>

                <div class="mb-4">

                    <label>

                        Confirm Password

                    </label>

                    <input
                        type="password"
                        name="confirm_password"
                        class="form-control">

                </div>

                <button
                    class="btn btn-primary">

                    Change Password

                </button>

            </form>

        </div>

    </div>

</div>

<br>



</div>

</div>

<?php include '../includes/footer.php'; ?>

