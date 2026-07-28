<?php

require '../../config/session.php';
require '../../config/database.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../../login.php");
    exit;
}

$stmt = $conn->prepare("
    SELECT *
    FROM website_settings
    WHERE owner_id = :owner_id
");

$stmt->execute([
    ':owner_id' => $_SESSION['user_id']
]);

$settings = $stmt->fetch(PDO::FETCH_ASSOC);

$pageTitle = "Website Builder";
include '../../includes/header.php';
?>

<?php include '../../includes/sidebar.php'; ?>

<div class="main-content">

    <?php include '../../includes/navbar.php'; ?>

    <div class="content">

        <div class="dashboard-card">

            <div class="d-flex justify-content-between align-items-center mb-4">

                <h2 class="fw-bold text-success mb-0">

                    <i class="bi bi-globe2"></i>

                    Website Builder

                </h2>

                <button class="btn btn-success" form="websiteForm">

                    <i class="bi bi-floppy"></i>

                    Save Changes

                </button>

            </div>

            <form
                id="websiteForm"
                action="../../auth/update_website_settings.php"
                method="POST">

                <div class="row">

                    <div class="col-md-6 mb-4">

                        <label class="form-label fw-semibold">
                            Website Name
                        </label>

                        <input
                            type="text"
                            name="website_name"
                            class="form-control"
                            value="<?= htmlspecialchars($settings['website_name']) ?>">

                    </div>

                    <div class="col-md-6 mb-4">

                        <label class="form-label fw-semibold">
                            Tagline
                        </label>

                        <input
                            type="text"
                            name="tagline"
                            class="form-control"
                            value="<?= htmlspecialchars($settings['tagline']) ?>">

                    </div>

                </div>

                <div class="mb-4">

                    <label class="form-label fw-semibold">

                        About Business

                    </label>

                    <textarea
                        class="form-control"
                        rows="6"
                        name="about"><?= htmlspecialchars($settings['about']) ?></textarea>

                </div>

                <hr class="my-4">

                <h4 class="fw-bold mb-4">

                    Contact Information

                </h4>

                <div class="row">

                    <div class="col-md-4 mb-3">

                        <label class="form-label">

                            Contact Number

                        </label>

                        <input
                            type="text"
                            class="form-control"
                            name="contact_number"
                            value="<?= htmlspecialchars($settings['contact_number']) ?>">

                    </div>

                    <div class="col-md-4 mb-3">

                        <label class="form-label">

                            Email Address

                        </label>

                        <input
                            type="email"
                            class="form-control"
                            name="email"
                            value="<?= htmlspecialchars($settings['email']) ?>">

                    </div>

                    <div class="col-md-4 mb-3">

                        <label class="form-label">

                            Facebook Page

                        </label>

                        <input
                            type="text"
                            class="form-control"
                            name="facebook"
                            value="<?= htmlspecialchars($settings['facebook']) ?>">

                    </div>

                </div>

                <hr class="my-4">

                <h4 class="fw-bold mb-4">

                    Branding

                </h4>

                <div class="row">

                    <div class="col-md-6">

                        <div class="border rounded-4 p-5 text-center bg-light">

                            <i class="bi bi-image fs-1 text-success"></i>

                            <h5 class="mt-3">

                                Website Logo

                            </h5>

                            <small class="text-muted">

                                Upload feature will be added next.

                            </small>

                        </div>

                    </div>

                    <div class="col-md-6">

                        <div class="border rounded-4 p-5 text-center bg-light">

                            <i class="bi bi-card-image fs-1 text-success"></i>

                            <h5 class="mt-3">

                                Hero Banner

                            </h5>

                            <small class="text-muted">

                                Upload feature will be added next.

                            </small>

                        </div>

                    </div>

                </div>

            </form>

        </div>

    </div>

</div>

<?php include '../../includes/footer.php'; ?>