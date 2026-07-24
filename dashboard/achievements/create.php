<?php

require '../../config/session.php';
require '../../config/database.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../../login.php");
    exit;
}

include '../../includes/header.php';
include '../../includes/navbar.php';

?>

<div class="d-flex">

    <?php include '../../includes/sidebar.php'; ?>

    <div class="container-fluid p-4">

        <div class="card shadow mx-auto" style="max-width:800px;">

            <div class="card-header bg-success text-white">

                <h3 class="mb-0">
                    Add Achievement
                </h3>

            </div>

            <div class="card-body">

                <form
                    action="../../auth/save_achievement.php"
                    method="POST"
                    enctype="multipart/form-data">

                    <div class="mb-3">

                        <label class="form-label">
                            Title
                        </label>

                        <input
                            type="text"
                            name="title"
                            class="form-control"
                            required>

                    </div>

                    <div class="mb-3">

                        <label class="form-label">
                            Description
                        </label>

                        <textarea
                            name="description"
                            class="form-control"
                            rows="5"
                            required></textarea>

                    </div>

                    <div class="mb-3">

                        <label class="form-label">
                            Award Date
                        </label>

                        <input
                            type="date"
                            name="award_date"
                            class="form-control"
                            required>

                    </div>

                    <div class="mb-4">

                        <label class="form-label">
                            Achievement Image
                        </label>

                        <input
                            type="file"
                            name="image"
                            class="form-control"
                            accept=".jpg,.jpeg,.png,.webp"
                            required>

                    </div>

                    <button
                        type="submit"
                        class="btn btn-success">

                        Save Achievement

                    </button>

                    <a
                        href="index.php"
                        class="btn btn-secondary">

                        Cancel

                    </a>

                </form>

            </div>

        </div>

    </div>

</div>

<?php include '../../includes/footer.php'; ?>