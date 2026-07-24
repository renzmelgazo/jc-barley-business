<?php

require '../../config/session.php';
require '../../config/database.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../../login.php");
    exit;
}

if (!isset($_GET['id'])) {
    die("Achievement ID is missing.");
}

$stmt = $conn->prepare("
    SELECT *
    FROM achievements
    WHERE id = :id
    AND owner_id = :owner_id
");

$stmt->execute([
    ':id' => $_GET['id'],
    ':owner_id' => $_SESSION['user_id']
]);

$achievement = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$achievement) {
    die("Achievement not found.");
}

include '../../includes/header.php';
include '../../includes/navbar.php';

?>

<div class="d-flex">

    <?php include '../../includes/sidebar.php'; ?>

    <div class="container-fluid p-4">

        <div class="card shadow mx-auto" style="max-width:800px;">

            <div class="card-header bg-primary text-white">

                <h3 class="mb-0">
                    Edit Achievement
                </h3>

            </div>

            <div class="card-body">

                <form
                    action="../../auth/update_achievement.php"
                    method="POST"
                    enctype="multipart/form-data">

                    <input
                        type="hidden"
                        name="id"
                        value="<?= $achievement['id'] ?>">

                    <input
                        type="hidden"
                        name="old_image"
                        value="<?= $achievement['image'] ?>">

                    <div class="mb-3">

                        <label class="form-label">
                            Title
                        </label>

                        <input
                            type="text"
                            name="title"
                            class="form-control"
                            value="<?= htmlspecialchars($achievement['title']) ?>"
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
                            required><?= htmlspecialchars($achievement['description']) ?></textarea>

                    </div>

                    <div class="mb-3">

                        <label class="form-label">
                            Award Date
                        </label>

                        <input
                            type="date"
                            name="award_date"
                            class="form-control"
                            value="<?= $achievement['award_date'] ?>"
                            required>

                    </div>

                    <div class="mb-3">

                        <label class="form-label">
                            Current Image
                        </label>

                        <br>

                        <img
                            src="../../uploads/achievements/<?= htmlspecialchars($achievement['image']) ?>"
                            style="width:250px;border-radius:10px;"
                            class="mb-3">

                    </div>

                    <div class="mb-4">

                        <label class="form-label">
                            Replace Image (Optional)
                        </label>

                        <input
                            type="file"
                            name="image"
                            class="form-control"
                            accept=".jpg,.jpeg,.png,.webp">

                    </div>

                    <button
                        type="submit"
                        class="btn btn-primary">

                        Update Achievement

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