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

    <?php

date_default_timezone_set('Asia/Manila');

$hour = date('H');

if($hour < 12){

    $greeting = "Good Morning ☀️";

}elseif($hour < 18){

    $greeting = "Good Afternoon 🌤";

}else{

    $greeting = "Good Evening 🌙";

}

?>

<div class="dashboard-header mb-4">

    <div class="row align-items-center">

        <div class="col-md-8">

            <span class="badge bg-success px-3 py-2 mb-2">

                Business Website Control Center

            </span>

            <h2 class="fw-bold mt-2">

                <?= $greeting ?>,
                <?= htmlspecialchars($user['fullname']) ?>

            </h2>

            <p class="text-muted mb-0">

                Monitor your website, manage content, and grow your business from one dashboard.

            </p>

        </div>

        <div class="col-md-4 text-end">

            <div class="text-muted">

                <?= date('l') ?>

            </div>

            <h5 class="fw-bold">

                <?= date('F d, Y') ?>

            </h5>

            <a
            href="<?= BASE_URL ?>/site.php?owner=<?= htmlspecialchars($user['site_slug']) ?>"
            target="_blank"
            class="btn btn-success mt-2">

                <i class="bi bi-box-arrow-up-right"></i>

                Visit Website

            </a>

        </div>

    </div>

</div>

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

    
    

<!-- Dashboard Grid -->

<div class="row g-4">

    <!-- Quick Actions -->

    <div class="col-lg-8">

        <div class="card shadow-sm border-0 rounded-4 h-100">

            <div class="card-body p-4">

                <h4 class="fw-bold mb-4">
                    Quick Actions
                </h4>

                <div class="row g-3">

                    <div class="col-md-6">

                        <a href="website-builder/index.php" class="text-decoration-none">

                            <div class="card border-0 shadow-sm rounded-4 p-4 h-100 action-card">

                                <i class="bi bi-globe2 fs-1 text-success"></i>

                                <h5 class="mt-3 fw-bold">
                                    Website Builder
                                </h5>

                                <p class="text-muted mb-0">
                                    Customize your website.
                                </p>

                            </div>

                        </a>

                    </div>

                    <div class="col-md-6">

                        <a href="gallery/index.php" class="text-decoration-none">

                            <div class="card border-0 shadow-sm rounded-4 p-4 h-100 action-card">

                                <i class="bi bi-images fs-1 text-primary"></i>

                                <h5 class="mt-3 fw-bold">
                                    Gallery
                                </h5>

                                <p class="text-muted mb-0">
                                    Upload images.
                                </p>

                            </div>

                        </a>

                    </div>

                    <div class="col-md-6">

                        <a href="achievements/index.php" class="text-decoration-none">

                            <div class="card border-0 shadow-sm rounded-4 p-4 h-100 action-card">

                                <i class="bi bi-trophy fs-1 text-warning"></i>

                                <h5 class="mt-3 fw-bold">
                                    Achievements
                                </h5>

                                <p class="text-muted mb-0">
                                    Manage awards.
                                </p>

                            </div>

                        </a>

                    </div>

                    <div class="col-md-6">

                        <a href="testimonials/index.php" class="text-decoration-none">

                            <div class="card border-0 shadow-sm rounded-4 p-4 h-100 action-card">

                                <i class="bi bi-chat-square-quote fs-1 text-info"></i>

                                <h5 class="mt-3 fw-bold">
                                    Testimonials
                                </h5>

                                <p class="text-muted mb-0">
                                    Manage testimonials.
                                </p>

                            </div>

                        </a>

                    </div>

                </div>

            </div>

        </div>

    </div>

    <!-- Website Information -->

    <div class="col-lg-4">

        <div class="card shadow-sm border-0 rounded-4 h-100">

            <div class="card-body p-4">

                <h4 class="fw-bold mb-4">

                    Website Information

                </h4>

                <p class="mb-2">

                    <strong>Status</strong>

                </p>

                <span class="badge bg-success rounded-pill px-3 py-2">

                    Online

                </span>

                <hr>

                <p>

                    <strong>Public Link</strong>

                </p>

                <input

                    id="websiteLink"
                    class="form-control mb-3"
                    readonly
                    value="<?= BASE_URL ?>/site.php?owner=<?= htmlspecialchars($user['site_slug']) ?>">

                <div class="d-grid gap-2">

                    <button
type="button"
class="btn btn-success"
onclick="copyWebsiteLink(this)">

<i class="bi bi-copy"></i>

Copy Link

</button>   

                    <a

                        href="<?= BASE_URL ?>/site.php?owner=<?= htmlspecialchars($user['site_slug']) ?>"

                        target="_blank"

                        class="btn btn-outline-success">

                        <i class="bi bi-box-arrow-up-right"></i>

                        Open Website

                    </a>

                </div>

            

        </div>

    </div>

</div>

      
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