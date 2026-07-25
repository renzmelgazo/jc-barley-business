<?php

require '../../config/session.php';
require '../../config/database.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../../login.php");
    exit;
}

$stmt = $conn->prepare("
    SELECT *
    FROM contact_messages
    WHERE owner_id = :owner_id
    ORDER BY created_at DESC
");

$stmt->execute([
    ':owner_id' => $_SESSION['user_id']
]);

$messages = $stmt->fetchAll(PDO::FETCH_ASSOC);

include '../../includes/header.php';
include '../../includes/navbar.php';

?>

<div class="d-flex">

    <?php include '../../includes/sidebar.php'; ?>

    <div class="container-fluid p-4">

        <h2 class="mb-4">Contact Messages</h2>

        <div class="card shadow">

            <div class="card-body">

                <table class="table table-bordered table-hover">

                    <thead class="table-success">

                        <tr>

                            <th width="70">ID</th>

                            <th>Full Name</th>

                            <th>Email</th>

                            <th>Subject</th>

                            <th>Status</th>

                            <th width="140">Date</th>

                            <th width="180">Action</th>

                        </tr>

                    </thead>

                    <tbody>

                    <?php if(count($messages) > 0): ?>

                        <?php foreach($messages as $row): ?>

                        <tr>

                            <td><?= $row['id'] ?></td>

                            <td><?= htmlspecialchars($row['fullname']) ?></td>

                            <td><?= htmlspecialchars($row['email']) ?></td>

                            <td><?= htmlspecialchars($row['subject']) ?></td>

                            <td>

                                <?php if($row['status'] == 'Unread'): ?>

                                    <span class="badge bg-danger">

                                        Unread

                                    </span>

                                <?php else: ?>

                                    <span class="badge bg-success">

                                        Read

                                    </span>

                                <?php endif; ?>

                            </td>

                            <td>

                                <?= date('M d, Y', strtotime($row['created_at'])) ?>

                            </td>

                            <td>

                                <a
                                    href="view.php?id=<?= $row['id'] ?>"
                                    class="btn btn-primary btn-sm">

                                    View

                                </a>

                                <a
                                    href="../../auth/delete_message.php?id=<?= $row['id'] ?>"
                                    class="btn btn-danger btn-sm"
                                    onclick="return confirm('Delete this message?')">

                                    Delete

                                </a>

                            </td>

                        </tr>

                        <?php endforeach; ?>

                    <?php else: ?>

                        <tr>

                            <td colspan="7" class="text-center">

                                No messages found.

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