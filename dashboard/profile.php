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

$profileImage = !empty($user['profile_picture'])
    ? "../uploads/profiles/" . $user['profile_picture']
    : "../assets/images/default-avatar.png";

$pageTitle = "My Profile";
include '../includes/header.php';
?>

<?php include '../includes/sidebar.php'; ?>

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

        <h2 class="fw-bold mb-4">My Profile</h2>



        <div class="card shadow-lg border-0 rounded-4 mx-auto" style="max-width:950px;">

            <div class="card-body p-5">

                <div class="row">

                    <!-- LEFT -->
                    <div class="col-md-4 text-center border-end">

                        <img
    src="<?= $profileImage ?>"
    class="rounded-circle shadow border border-3 mb-4"
    alt="Profile Picture"
    style="
        width:200px;
        height:200px;
        object-fit:cover;
        border-color:#198754!important;
    ">

                        <form
                            action="../auth/upload_profile.php"
                            method="POST"
                            enctype="multipart/form-data">

                            <input
    type="file"
    name="profile_picture"
    class="form-control mb-2"
    accept=".jpg,.jpeg,.png,.webp"
    required>

<small class="text-muted">

Allowed:
JPG, JPEG, PNG, WEBP
(Maximum 2MB)

</small>

                            <button
                                class="btn btn-success w-100">

                                Upload Picture

                            </button>

                        </form>

                    </div>

                    <!-- RIGHT -->
                    <div class="col-md-8 ps-md-5">

                        <h3 class="fw-bold mb-4">
                            <?= htmlspecialchars($user['fullname']) ?>
                        </h3>

                        <div class="row mb-3">

                            <div class="col-sm-4 fw-bold">
                                Username
                            </div>

                            <div class="col-sm-8">
                                <?= htmlspecialchars($user['username']) ?>
                            </div>

                        </div>

                        <hr>

                        <div class="row mb-3">

                            <div class="col-sm-4 fw-bold">
                                Email
                            </div>

                            <div class="col-sm-8">
                                <?= htmlspecialchars($user['email']) ?>
                            </div>

                        </div>

                        <hr>

                        <div class="row mb-3">

                            <div class="col-sm-4 fw-bold">
                                Status
                            </div>

                            <div class="col-sm-8">

                                <span class="badge bg-success fs-6">
                                    <?= ucfirst($user['status']) ?>
                                </span>

                            </div>

                        </div>

                        <hr>

                        <div class="row mb-4">

                            <div class="col-sm-4 fw-bold">
                                Member Since
                            </div>

                            <div class="col-sm-8">
                                <?= date('F d, Y', strtotime($user['created_at'])) ?>
                            </div>

                        </div>

                        <div class="d-flex gap-3">

                            <a
                                href="edit-profile.php"
                                class="btn btn-primary">

                                Edit Profile

                            </a>

                            <a
                                href="change-password.php"
                                class="btn btn-outline-secondary">

                                Change Password

                            </a>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

<?php include '../includes/footer.php'; ?>