<?php

require '../../config/session.php';
require '../../config/database.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../../login.php");
    exit;
}

$stmt = $conn->prepare("
    SELECT *
    FROM gallery
    ORDER BY created_at DESC
");

$stmt->execute();

$gallery = $stmt->fetchAll(PDO::FETCH_ASSOC);

include '../../includes/header.php';
include '../../includes/navbar.php';

?>

<div class="d-flex">

    <?php include '../../includes/sidebar.php'; ?>

    <div class="container-fluid p-4">

        <div class="d-flex justify-content-between align-items-center mb-4">

            <h2>Gallery Management</h2>

            <a href="create.php" class="btn btn-success">
                + Add Image
            </a>

        </div>

        <div class="card shadow">

            <div class="card-body">

                <table class="table table-bordered table-hover">

                    <thead class="table-success">

                        <tr>

                            <th width="80">ID</th>

                            <th width="150">Image</th>

                            <th>Title</th>

                            <th>Description</th>

                            <th width="180">Action</th>

                        </tr>

                    </thead>

                    <tbody>

                        <?php if(count($gallery) > 0): ?>

                            <?php foreach($gallery as $row): ?>

                                <tr>

                                    <td><?= $row['id'] ?></td>

                                    <td>

                                        <img
                                            src="../../uploads/gallery/<?= htmlspecialchars($row['image']) ?>"
                                            width="120"
                                            class="rounded">

                                    </td>

                                    <td>

                                        <?= htmlspecialchars($row['title']) ?>

                                    </td>

                                    <td>

                                        <?= htmlspecialchars($row['description']) ?>

                                    </td>

                                    <td>

                                        <a
                                            href="edit.php?id=<?= $row['id'] ?>"
                                            class="btn btn-primary btn-sm">

                                            Edit

                                        </a>

                                        <a
                                            href="../../auth/delete_gallery.php?id=<?= $row['id'] ?>"
                                            class="btn btn-danger btn-sm"
                                            onclick="return confirm('Delete this image?')">

                                            Delete

                                        </a>

                                    </td>

                                </tr>

                            <?php endforeach; ?>

                        <?php else: ?>

                            <tr>

                                <td colspan="5" class="text-center">

                                    No gallery images found.

                                </td>

                            </tr>

                        <?php endif; ?>

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</div>

<?php include '../../includes/footer.php'; ?>