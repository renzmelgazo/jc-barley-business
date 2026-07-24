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

include '../includes/header.php';
include '../includes/navbar.php';
?>

<div class="d-flex">

    <?php include '../includes/sidebar.php'; ?>

    <div class="container-fluid p-5">

        <div class="card shadow mx-auto" style="max-width:700px;">

            <div class="card-header bg-success text-white">

                <h3 class="mb-0">
                    Edit Profile
                </h3>

            </div>

            <div class="card-body">

                <form
                    action="../auth/update_profile.php"
                    method="POST">

                    <div class="mb-3">

                        <label class="form-label">
                            Full Name
                        </label>

                        <input
                            type="text"
                            name="fullname"
                            class="form-control"
                            value="<?= htmlspecialchars($user['fullname']) ?>"
                            required>

                    </div>

                    <div class="mb-3">

                        <label class="form-label">
                            Username
                        </label>

                        <input
                            type="text"
                            name="username"
                            class="form-control"
                            value="<?= htmlspecialchars($user['username']) ?>"
                            required>

                    </div>

                    <div class="mb-3">

                        <label class="form-label">
                            Email
                        </label>

                        <input
                            type="email"
                            name="email"
                            class="form-control"
                            value="<?= htmlspecialchars($user['email']) ?>"
                            required>

                    </div>

                    <button
                        type="submit"
                        class="btn btn-success">

                        Save Changes

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