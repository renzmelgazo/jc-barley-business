<?php

require '../config/session.php';
require '../config/database.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit;
}

$userId = $_SESSION['user_id'];

/*
|--------------------------------------------------------------------------
| Dashboard Statistics
|--------------------------------------------------------------------------
*/

// Website Slug
$stmt = $conn->prepare("
    SELECT site_slug
    FROM users
    WHERE id = :id
");
$stmt->execute([
    ':id' => $userId
]);

$userSite = $stmt->fetch(PDO::FETCH_ASSOC);

$websiteLink = "http://localhost:8888/jc-barley-website/site.php?owner=" .
urlencode($userSite['site_slug'] ?? '');

// Achievements
$stmt = $conn->prepare("
    SELECT COUNT(*)
    FROM achievements
    WHERE owner_id = :owner_id
");

$stmt->execute([
    ':owner_id' => $userId
]);

$totalAchievements = $stmt->fetchColumn();

// Gallery
$stmt = $conn->prepare("
    SELECT COUNT(*)
    FROM gallery
    WHERE owner_id = :owner_id
");


$stmt->execute([
    ':owner_id' => $userId
]);

$totalGallery = $stmt->fetchColumn();

// Messages
$stmt = $conn->prepare("
SELECT
COUNT(*) AS total,
SUM(CASE WHEN status='Unread' THEN 1 ELSE 0 END) AS unread
FROM contact_messages
WHERE owner_id=:owner_id
");

$stmt->execute([
':owner_id'=>$userId
]);

$messageStats = $stmt->fetch(PDO::FETCH_ASSOC);

$totalMessages = $messageStats['total'] ?? 0;
$unreadMessages = $messageStats['unread'] ?? 0;

// Recent Messages
$stmt = $conn->prepare("
SELECT
fullname,
subject,
status,
created_at
FROM contact_messages
WHERE owner_id=:owner_id
ORDER BY created_at DESC
LIMIT 5
");

$stmt->execute([
':owner_id'=>$userId
]);

$recentMessages = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Recent Achievements
$stmt = $conn->prepare("
SELECT
title,
award_date
FROM achievements
WHERE owner_id=:owner_id
ORDER BY award_date DESC
LIMIT 5
");

$stmt->execute([
':owner_id'=>$userId
]);

$recentAchievements = $stmt->fetchAll(PDO::FETCH_ASSOC);



$pageTitle = "Dashboard";

include '../includes/header.php';

?>

<?php include '../includes/sidebar.php'; ?>

<div class="main-content">

<?php include '../includes/navbar.php'; ?>
<div class="content">


        <!-- Website Actions -->
<div class="dashboard-card mb-4">

    <div class="d-flex justify-content-between align-items-center flex-wrap">

        <div>

            <h5 class="fw-bold mb-1">
                My Website
            </h5>

            <p class="text-muted mb-0">
                Visit or share your public website.
            </p>

        </div>

        <div class="d-flex gap-2 mt-3 mt-md-0">

            <a
                href="<?= $websiteLink ?>"
                target="_blank"
                class="btn btn-success">

                <i class="bi bi-globe2 me-2"></i>
                Visit Website

            </a>

            <button
                class="btn btn-outline-primary"
                onclick="copyWebsiteLink()">

                <i class="bi bi-copy me-2"></i>
                Copy Website

            </button>

        </div>

    </div>

</div>


<!-- Dashboard Shortcuts -->
<div class="row g-4 mb-5">

    <div class="col-xl-3 col-md-6">

        <a href="gallery/index.php" class="text-decoration-none">

            <div class="card dashboard-shortcut border-0 shadow-sm h-100">

                <div class="card-body text-center py-4">

                    <div class="shortcut-icon bg-primary-subtle text-primary">

                        <i class="bi bi-images"></i>

                    </div>

                    <h5 class="mt-3 fw-bold">
                        Gallery
                    </h5>

                    <div class="display-6 fw-bold text-primary mt-2">
                        <?= $totalGallery ?>
                    </div>

                    <p class="text-muted mb-0">
                        Uploaded Images
                    </p>

                </div>

            </div>

        </a>

    </div>


    <div class="col-xl-3 col-md-6">

        <a href="achievements/index.php" class="text-decoration-none">

            <div class="card dashboard-shortcut border-0 shadow-sm h-100">

                <div class="card-body text-center py-4">

                    <div class="shortcut-icon bg-success-subtle text-success">

                        <i class="bi bi-trophy-fill"></i>

                    </div>

                    <h5 class="mt-3 fw-bold">
                        Achievements
                    </h5>

                    <div class="display-6 fw-bold text-success mt-2">
                        <?= $totalAchievements ?>
                    </div>

                    <p class="text-muted mb-0">
                        Awards & Certificates
                    </p>

                </div>

            </div>

        </a>

    </div>


    <div class="col-xl-3 col-md-6">

        <a href="testimonials/index.php" class="text-decoration-none">

            <div class="card dashboard-shortcut border-0 shadow-sm h-100">

                <div class="card-body text-center py-4">

                    <div class="shortcut-icon bg-warning-subtle text-warning">

                        <i class="bi bi-chat-square-quote-fill"></i>

                    </div>

                    <h5 class="mt-3 fw-bold">
                        Testimonials
                    </h5>

                    <div class="display-6 fw-bold text-warning mt-2">
                        —
                    </div>

                    <p class="text-muted mb-0">
                        Client Feedback
                    </p>

                </div>

            </div>

        </a>

    </div>


    <div class="col-xl-3 col-md-6">

        <a href="messages/index.php" class="text-decoration-none">

            <div class="card dashboard-shortcut border-0 shadow-sm h-100">

                <div class="card-body text-center py-4">

                    <div class="shortcut-icon bg-danger-subtle text-danger">

                        <i class="bi bi-envelope-fill"></i>

                    </div>

                    <h5 class="mt-3 fw-bold">
                        Messages
                    </h5>

                    <div class="display-6 fw-bold text-danger mt-2">
                        <?= $unreadMessages ?>
                    </div>

                    <p class="text-muted mb-0">
                        Unread Messages
                    </p>

                </div>

            </div>

        </a>

    </div>

</div>

<!-- Recent Messages -->
<div class="card shadow-sm border-0">

    <div class="card-header bg-primary text-white py-3">

        <h5 class="mb-0">
            <i class="bi bi-envelope-fill me-2"></i>
            Recent Messages
        </h5>

    </div>

    <div class="card-body p-0">

        <div class="table-responsive">

            <table class="table table-hover align-middle mb-0">

                <thead class="table-light">

                    <tr>

                        <th class="ps-4">Name</th>

                        <th>Subject</th>

                        <th>Status</th>

                    </tr>

                </thead>

                <tbody>

                <?php if(!empty($recentMessages)): ?>

                    <?php foreach($recentMessages as $message): ?>

                    <tr>

                        <td class="ps-4 fw-semibold">

                            <?= htmlspecialchars($message['fullname']) ?>

                        </td>

                        <td>

                            <?= htmlspecialchars($message['subject']) ?>

                        </td>

                        <td>

                            <?php if($message['status']=='Unread'): ?>

                                <span class="badge bg-danger">
                                    Unread
                                </span>

                            <?php else: ?>

                                <span class="badge bg-success">
                                    Read
                                </span>

                            <?php endif; ?>

                        </td>

                    </tr>

                    <?php endforeach; ?>

                <?php else: ?>

                    <tr>

                        <td colspan="3" class="text-center py-4 text-muted">

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

<style>

.dashboard-shortcut{

    transition:.25s;

    border-radius:18px;

}

.dashboard-shortcut:hover{

    transform:translateY(-8px);

    box-shadow:0 18px 35px rgba(0,0,0,.12)!important;

}

.shortcut-icon{

    width:70px;

    height:70px;

    border-radius:50%;

    display:flex;

    justify-content:center;

    align-items:center;

    margin:auto;

    font-size:30px;

}

</style>

<script>

function copyWebsiteLink() {

    const link = <?= json_encode($websiteLink) ?>;

    if (navigator.clipboard) {

        navigator.clipboard.writeText(link)
        .then(() => {
            alert("Website link copied successfully!");
        });

    } else {

        prompt("Copy this link:", link);

    }

}

</script>

<?php include '../includes/footer.php'; ?>