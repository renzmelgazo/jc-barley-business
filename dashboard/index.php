<?php

require '../config/session.php';
require '../config/database.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit;
}

/*
|--------------------------------------------------------------------------
| Dashboard Statistics
|--------------------------------------------------------------------------
*/

$totalAchievements = $conn->query("
    SELECT COUNT(*)
    FROM achievements
")->fetchColumn();

$totalGallery = $conn->query("
    SELECT COUNT(*)
    FROM gallery
")->fetchColumn();

$totalMessages = $conn->query("
    SELECT COUNT(*)
    FROM contact_messages
")->fetchColumn();

$unreadMessages = $conn->query("
    SELECT COUNT(*)
    FROM contact_messages
    WHERE status = 'Unread'
")->fetchColumn();

/*
|--------------------------------------------------------------------------
| Recent Achievements
|--------------------------------------------------------------------------
*/

$stmt = $conn->prepare("
    SELECT title, award_date
    FROM achievements
    ORDER BY award_date DESC
    LIMIT 5
");

$stmt->execute();
$recentAchievements = $stmt->fetchAll(PDO::FETCH_ASSOC);

/*
|--------------------------------------------------------------------------
| Recent Messages
|--------------------------------------------------------------------------
*/

$stmt = $conn->prepare("
    SELECT fullname, subject, status, created_at
    FROM contact_messages
    ORDER BY created_at DESC
    LIMIT 5
");

$stmt->execute();
$recentMessages = $stmt->fetchAll(PDO::FETCH_ASSOC);

include '../includes/header.php';
include '../includes/navbar.php';

?>

<div class="d-flex">

    <?php include '../includes/sidebar.php'; ?>

    <div class="container-fluid p-4">

        <h2 class="fw-bold mb-4">Dashboard</h2>

        <div class="row">

            <div class="col-md-3 mb-4">
                <div class="card border-0 shadow bg-success text-white">
                    <div class="card-body">
                        <h5>Achievements</h5>
                        <h2><?= $totalAchievements ?></h2>
                    </div>
                </div>
            </div>

            <div class="col-md-3 mb-4">
                <div class="card border-0 shadow bg-primary text-white">
                    <div class="card-body">
                        <h5>Gallery Images</h5>
                        <h2><?= $totalGallery ?></h2>
                    </div>
                </div>
            </div>

            <div class="col-md-3 mb-4">
                <div class="card border-0 shadow bg-info text-white">
                    <div class="card-body">
                        <h5>Total Messages</h5>
                        <h2><?= $totalMessages ?></h2>
                    </div>
                </div>
            </div>

            <div class="col-md-3 mb-4">
                <div class="card border-0 shadow bg-danger text-white">
                    <div class="card-body">
                        <h5>Unread Messages</h5>
                        <h2><?= $unreadMessages ?></h2>
                    </div>
                </div>
            </div>

        </div>

        <!-- System Overview -->
        <div class="card shadow border-0 mb-4">

            <div class="card-header">
                <h4 class="mb-0">System Overview</h4>
            </div>

            <div class="card-body">

                <table class="table table-bordered align-middle">

                    <tr>
                        <th width="250">Total Achievements</th>
                        <td><?= $totalAchievements ?></td>
                    </tr>

                    <tr>
                        <th>Total Gallery Images</th>
                        <td><?= $totalGallery ?></td>
                    </tr>

                    <tr>
                        <th>Total Contact Messages</th>
                        <td><?= $totalMessages ?></td>
                    </tr>

                    <tr>
                        <th>Unread Messages</th>
                        <td><?= $unreadMessages ?></td>
                    </tr>

                </table>

            </div>

        </div>

        <!-- Recent Tables -->
        <div class="row">

            <!-- Recent Achievements -->
            <div class="col-lg-6 mb-4">

                <div class="card shadow border-0">

                    <div class="card-header bg-success text-white">
                        <h5 class="mb-0">Recent Achievements</h5>
                    </div>

                    <div class="card-body">

                        <table class="table table-hover">

                            <thead>
                                <tr>
                                    <th>Title</th>
                                    <th>Date</th>
                                </tr>
                            </thead>

                            <tbody>

                            <?php if(count($recentAchievements) > 0): ?>

                                <?php foreach($recentAchievements as $achievement): ?>

                                <tr>
                                    <td><?= htmlspecialchars($achievement['title']) ?></td>
                                    <td><?= date('M d, Y', strtotime($achievement['award_date'])) ?></td>
                                </tr>

                                <?php endforeach; ?>

                            <?php else: ?>

                                <tr>
                                    <td colspan="2" class="text-center text-muted">
                                        No achievements found.
                                    </td>
                                </tr>

                            <?php endif; ?>

                            </tbody>

                        </table>

                    </div>

                </div>

            </div>

            <!-- Recent Messages -->
            <div class="col-lg-6 mb-4">

                <div class="card shadow border-0">

                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">Recent Messages</h5>
                    </div>

                    <div class="card-body">

                        <table class="table table-hover">

                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Subject</th>
                                    <th>Status</th>
                                </tr>
                            </thead>

                            <tbody>

                            <?php if(count($recentMessages) > 0): ?>

                                <?php foreach($recentMessages as $message): ?>

                                <tr>

                                    <td><?= htmlspecialchars($message['fullname']) ?></td>

                                    <td><?= htmlspecialchars($message['subject']) ?></td>

                                    <td>

                                        <?php if($message['status'] == 'Unread'): ?>

                                            <span class="badge bg-danger">Unread</span>

                                        <?php else: ?>

                                            <span class="badge bg-success">Read</span>

                                        <?php endif; ?>

                                    </td>

                                </tr>

                                <?php endforeach; ?>

                            <?php else: ?>

                                <tr>
                                    <td colspan="3" class="text-center text-muted">
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

    </div>

</div>

<?php include '../includes/footer.php'; ?>