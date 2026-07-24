<?php

require '../config/session.php';
require '../config/database.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit;
}

include '../includes/header.php';
include '../includes/navbar.php';

?>

<div class="d-flex">

    <?php include '../includes/sidebar.php'; ?>

    <div class="container-fluid p-5">

        <div class="card shadow mx-auto" style="max-width:600px;">

            <div class="card-header bg-success text-white">

                <h3 class="mb-0">
                    Change Password
                </h3>

            </div>

            <div class="card-body">

                <form action="../auth/update_password.php" method="POST">

                    <div class="mb-3">

                        <label class="form-label">
                            Current Password
                        </label>

                        <input
                            type="password"
                            name="current_password"
                            class="form-control"
                            required>

                    </div>

                    <div class="mb-3">

                        <label class="form-label">
                            New Password
                        </label>

                        <input
                            type="password"
                            name="new_password"
                            class="form-control"
                            required>

                    </div>

                    <div class="mb-3">

                        <label class="form-label">
                            Confirm New Password
                        </label>

                        <input
                            type="password"
                            name="confirm_password"
                            class="form-control"
                            required>

                    </div>

                    <button
                        type="submit"
                        class="btn btn-success">

                        Update Password

                    </button>

                    <a
                        href="profile.php"
                        class="btn btn-secondary">

                        Cancel

                    </a>

                </form>

            </div>

        </div>

    </div>

</div>

<?php include '../includes/footer.php'; ?>