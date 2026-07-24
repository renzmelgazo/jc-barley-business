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

include '../includes/header.php';
include '../includes/navbar.php';
?>

<div class="d-flex">

    <?php include '../includes/sidebar.php'; ?>

    <div class="container-fluid p-5">

        <h2 class="fw-bold mb-4">My Profile</h2>

        <div class="card shadow-lg border-0 rounded-4 mx-auto" style="max-width:950px;">

            <div class="card-body p-5">

                <div class="row">

                    <!-- LEFT -->
                    <div class="col-md-4 text-center border-end">

                        <img
src="<?= $profileImage ?>"
class="rounded-circle shadow border border-3 mb-4 profile-picture"
alt="Profile Picture">

                        <form
                            action="../auth/upload_profile.php"
                            method="POST"
                            enctype="multipart/form-data">

                            <input
                                type="file"
                                name="profile_picture"
                                class="form-control mb-3"
                                accept=".jpg,.jpeg,.png,.webp"
                                required>

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