<?php

require '../../config/session.php';

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

        <h2 class="mb-4">Add Gallery Image</h2>

        <div class="card shadow">

            <div class="card-body">

                <form
                    action="../../auth/save_gallery.php"
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
                            rows="4"></textarea>

                    </div>

                    <div class="mb-3">

                        <label class="form-label">
                            Image
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

                        Save Gallery

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