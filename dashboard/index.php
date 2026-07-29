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

$stmt = $conn->prepare("
    SELECT COUNT(*)
    FROM achievements
    WHERE owner_id = :owner_id
");

$stmt->execute([
    ':owner_id' => $_SESSION['user_id']
]);

$totalAchievements = $stmt->fetchColumn();

$stmt = $conn->prepare("
    SELECT COUNT(*)
    FROM gallery
    WHERE owner_id = :owner_id
");

$stmt->execute([
    ':owner_id' => $_SESSION['user_id']
]);

$totalGallery = $stmt->fetchColumn();

$stmt = $conn->prepare("
    SELECT COUNT(*)
    FROM contact_messages
    WHERE owner_id = :owner_id
");

$stmt->execute([
    ':owner_id' => $_SESSION['user_id']
]);

$totalMessages = $stmt->fetchColumn();

$stmt = $conn->prepare("
    SELECT COUNT(*)
    FROM contact_messages
    WHERE owner_id = :owner_id
    AND status = 'Unread'
");

$stmt->execute([
    ':owner_id' => $_SESSION['user_id']
]);

$unreadMessages = $stmt->fetchColumn();

/*
|--------------------------------------------------------------------------
| Recent Achievements
|--------------------------------------------------------------------------
*/

$stmt = $conn->prepare("
    SELECT
        title,
        award_date
    FROM achievements
    WHERE owner_id = :owner_id
    ORDER BY award_date DESC
    LIMIT 5
");

$stmt->execute([
    ':owner_id' => $_SESSION['user_id']
]);

$recentAchievements = $stmt->fetchAll(PDO::FETCH_ASSOC);

/*
|--------------------------------------------------------------------------
| Recent Messages
|--------------------------------------------------------------------------
*/

$stmt = $conn->prepare("
    SELECT
        fullname,
        subject,
        status,
        created_at
    FROM contact_messages
    WHERE owner_id = :owner_id
    ORDER BY created_at DESC
    LIMIT 5
");

$stmt->execute([
    ':owner_id' => $_SESSION['user_id']
]);

$recentMessages = $stmt->fetchAll(PDO::FETCH_ASSOC);

$pageTitle = "Dashboard";
include '../includes/header.php';
?>

<?php include '../includes/sidebar.php'; ?>

<div class="main-content">

    <?php include '../includes/navbar.php'; ?>

    <div class="content">

        <div class="dashboard-card mb-4">

    <h2 class="fw-bold">

        Welcome back,
        <?= htmlspecialchars($_SESSION['fullname']) ?> 👋

    </h2>

    <p class="text-muted mb-0">

        Manage your business website, achievements, gallery, and customer messages from one place.

    </p>

</div>

        <?php

$stmt = $conn->prepare("
    SELECT site_slug
    FROM users
    WHERE id = :id
");

$stmt->execute([
    ':id' => $_SESSION['user_id']
]);

$userSite = $stmt->fetch(PDO::FETCH_ASSOC);

$websiteLink = "http://localhost:8888/jc-barley-website/site.php?owner=" . urlencode($userSite['site_slug']);

?>

<div class="mb-4 d-flex gap-2">

    <a
        href="<?= $websiteLink ?>"
        target="_blank"
        class="btn btn-success">

        🌐 View My Website

    </a>

    <button
        type="button"
        class="btn btn-outline-primary"
        onclick="copyWebsiteLink()">

        📋 Copy Website Link

    </button>

</div>

        <div class="row g-4 mb-5">

    <div class="col-xl-3 col-md-6">

        <div class="dashboard-card">

            <div class="d-flex justify-content-between align-items-center">

                <div>

                    <h6>Achievements</h6>

                    <h2><?= $totalAchievements ?></h2>

                </div>

                <i class="bi bi-trophy-fill stat-icon text-success"></i>

            </div>

        </div>

    </div>

    <div class="col-xl-3 col-md-6">

        <div class="dashboard-card">

            <div class="d-flex justify-content-between align-items-center">

                <div>

                    <h6>Gallery</h6>

                    <h2><?= $totalGallery ?></h2>

                </div>

                <i class="bi bi-images stat-icon text-primary"></i>

            </div>

        </div>

    </div>

    <div class="col-xl-3 col-md-6">

        <div class="dashboard-card">

            <div class="d-flex justify-content-between align-items-center">

                <div>

                    <h6>Messages</h6>

                    <h2><?= $totalMessages ?></h2>

                </div>

                <i class="bi bi-envelope-fill stat-icon text-warning"></i>

            </div>

        </div>

    </div>

    <div class="col-xl-3 col-md-6">

        <div class="dashboard-card">

            <div class="d-flex justify-content-between align-items-center">

                <div>

                    <h6>Unread</h6>

                    <h2><?= $unreadMessages ?></h2>

                </div>

                <i class="bi bi-bell-fill stat-icon text-danger"></i>

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

<script>

function copyWebsiteLink() {

    navigator.clipboard.writeText("<?= $websiteLink ?>");

    alert("Website link copied successfully!");

}

</script>

<?php include '../includes/footer.php'; ?>