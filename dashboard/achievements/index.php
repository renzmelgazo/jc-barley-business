<?php

require '../../config/session.php';
require '../../config/database.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../../login.php");
    exit;
}

$stmt = $conn->prepare("
    SELECT *
    FROM achievements
    WHERE owner_id = :owner_id
    ORDER BY award_date DESC
");

$stmt->execute([
    ':owner_id' => $_SESSION['user_id']
]);

$achievements = $stmt->fetchAll(PDO::FETCH_ASSOC);

include '../../includes/header.php';
?>

<?php include '../../includes/sidebar.php'; ?>

<div class="main-content">

    <?php include '../../includes/navbar.php'; ?>

    <div class="content">

        <div class="dashboard-card">

            <div class="d-flex justify-content-between align-items-center mb-4">

                <h2 class="fw-bold mb-0 text-success">
                    <i class="bi bi-trophy-fill"></i>
                    Achievements
                </h2>

                <a href="create.php" class="btn btn-success">
                    <i class="bi bi-plus-circle"></i>
                    Add Achievement
                </a>

            </div>

            <div class="table-responsive">

                <table class="table table-hover align-middle">

                    <thead class="table-success">

                        <tr>
                            <th width="80">ID</th>
                            <th>Title</th>
                            <th>Award Date</th>
                            <th width="180">Actions</th>
                        </tr>

                    </thead>

                    <tbody>

                        <?php if (count($achievements) > 0): ?>

                            <?php foreach ($achievements as $achievement): ?>

                                <tr>

                                    <td><?= $achievement['id']; ?></td>

                                    <td><?= htmlspecialchars($achievement['title']); ?></td>

                                    <td><?= date('F d, Y', strtotime($achievement['award_date'])); ?></td>

                                    <td>

                                        <a href="edit.php?id=<?= $achievement['id']; ?>"
                                           class="btn btn-primary btn-sm">

                                            <i class="bi bi-pencil"></i>
                                            Edit

                                        </a>

                                        <a href="../../auth/delete_achievement.php?id=<?= $achievement['id']; ?>"
                                           class="btn btn-danger btn-sm"
                                           onclick="return confirm('Delete this achievement?')">

                                            <i class="bi bi-trash"></i>
                                            Delete

                                        </a>

                                    </td>

                                </tr>

                            <?php endforeach; ?>

                        <?php else: ?>

                            <tr>

                                <td colspan="4" class="text-center text-muted py-4">

                                    No achievements found.

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