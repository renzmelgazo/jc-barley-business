<?php

require 'config/database.php';

// Check if owner slug exists
if (!isset($_GET['owner']) || empty($_GET['owner'])) {
    die("Owner not specified.");
}

$slug = trim($_GET['owner']);

// Get owner information
$stmt = $conn->prepare("
    SELECT *
    FROM users
    WHERE site_slug = :slug
    LIMIT 1
");

$stmt->execute([
    ':slug' => $slug
]);

$owner = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$owner) {
    die("Website not found.");
}

/*
|--------------------------------------------------------------------------
| Get Website Settings
|--------------------------------------------------------------------------
*/

$stmt = $conn->prepare("
    SELECT *
    FROM website_settings
    WHERE owner_id = :owner_id
");

$stmt->execute([
    ':owner_id' => $owner['id']
]);

$settings = $stmt->fetch(PDO::FETCH_ASSOC);

$stmt->execute([
    ':owner_id' => $owner['id']
]);

$settings = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$owner) {
    die("Website not found.");
}

// Save owner info
$ownerId = $owner['id'];
$ownerName = $owner['fullname'];

// Load Achievements
$stmt = $conn->prepare("
    SELECT *
    FROM achievements
    WHERE owner_id = :owner_id
    ORDER BY award_date DESC
");

$stmt->execute([
    ':owner_id' => $ownerId
]);

$achievements = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Load Gallery
$stmt = $conn->prepare("
    SELECT *
    FROM gallery
    WHERE owner_id = :owner_id
    ORDER BY created_at DESC
");

$stmt->execute([
    ':owner_id' => $ownerId
]);

$gallery = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>
<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">

<title>
<?= htmlspecialchars($settings['website_name'] ?: $ownerName) ?>
</title>

<link
href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
rel="stylesheet">

</head>

<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-success shadow sticky-top">

    <div class="container">

        <a class="navbar-brand fw-bold" href="#">

            <?= htmlspecialchars($settings['website_name']) ?>

        </a>

        <button
            class="navbar-toggler"
            type="button"
            data-bs-toggle="collapse"
            data-bs-target="#navbarNav">

            <span class="navbar-toggler-icon"></span>

        </button>

        <div
            class="collapse navbar-collapse"
            id="navbarNav">

            <ul class="navbar-nav ms-auto">

                <li class="nav-item">
                    <a class="nav-link" href="#home">
                        Home
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="#about">
                        About
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="#achievements">
                        Achievements
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="#gallery">
                        Gallery
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="#contact">
                        Contact
                    </a>
                </li>

            </ul>

        </div>

    </div>

</nav>

<div class="container py-5" id="home">

<div
    id="about"
    class="text-center py-5 mb-5 rounded shadow"
     style="background:#198754;color:white;">

    <h5 class="text-uppercase">

        <?= htmlspecialchars($settings['website_name']) ?>

    </h5>

    <h1 class="display-4 fw-bold mt-3">

        <?= htmlspecialchars($ownerName) ?>

    </h1>

    <p class="lead">

        <?= htmlspecialchars($settings['tagline']) ?>

    </p>

    <hr
        class="mx-auto"
        style="width:120px;border:2px solid white;">

    <p class="mt-3">

        <?= nl2br(htmlspecialchars($settings['about'])) ?>

    </p>

</div>

<h3>About</h3>

<p>

<?= nl2br(htmlspecialchars($settings['about'])) ?>

</p>

<hr>

<h2 id="achievements" class="text-center mb-5">

    🏆 Achievements

</h2>

<div class="row">

<?php if(count($achievements) > 0): ?>

    <?php foreach($achievements as $row): ?>

    <div class="col-md-4 mb-4">

        <div class="card h-100 shadow border-0">

            <img
                src="uploads/achievements/<?= htmlspecialchars($row['image']) ?>"
                class="card-img-top"
                style="height:220px;object-fit:cover;">

            <div class="card-body">

                <h5 class="fw-bold">

                    <?= htmlspecialchars($row['title']) ?>

                </h5>

                <small class="text-muted">

                    <?= date('F d, Y', strtotime($row['award_date'])) ?>

                </small>

                <hr>

                <p>

                    <?= nl2br(htmlspecialchars($row['description'])) ?>

                </p>

            </div>

        </div>

    </div>

    <?php endforeach; ?>

<?php else: ?>

<div class="col-12">

    <div class="alert alert-secondary text-center">

        No achievements available.

    </div>

</div>

<?php endif; ?>

</div>

<h2 id="gallery" class="text-center mt-5 mb-5">

    🖼 Gallery

</h2>

<div class="row">

<?php if(count($gallery) > 0): ?>

<?php foreach($gallery as $row): ?>

<div class="col-lg-3 col-md-4 col-sm-6 mb-4">

    <div class="card border-0 shadow h-100">

        <img
            src="uploads/gallery/<?= htmlspecialchars($row['image']) ?>"
            class="card-img-top"
            style="height:220px;object-fit:cover;">

        <div class="card-body text-center">

            <h6 class="fw-bold">

                <?= htmlspecialchars($row['title']) ?>

            </h6>

            <p class="small text-muted">

                <?= htmlspecialchars($row['description']) ?>

            </p>

        </div>

    </div>

</div>

<?php endforeach; ?>

<?php else: ?>

<div class="col-12">

    <div class="alert alert-secondary text-center">

        No gallery images available.

    </div>

</div>

<?php endif; ?>

</div>

<hr class="my-5">

<h3>Contact Information</h3>

<ul class="list-group mb-4">

<li class="list-group-item">

<strong>Phone:</strong>

<?= htmlspecialchars($settings['contact_number']) ?>

</li>

<li class="list-group-item">

<strong>Email:</strong>

<?= htmlspecialchars($settings['email']) ?>

</li>

<li class="list-group-item">

<strong>Facebook:</strong>

<?= htmlspecialchars($settings['facebook']) ?>

</li>

</ul>

<h3 id="contact">
    Contact <?= htmlspecialchars($ownerName) ?>
</h3>

<form action="auth/save_contact.php" method="POST">

    <input
        type="hidden"
        name="owner_id"
        value="<?= $ownerId ?>">

    <div class="mb-3">
        <input
            type="text"
            name="fullname"
            class="form-control"
            placeholder="Full Name"
            required>
    </div>

    <div class="mb-3">
        <input
            type="email"
            name="email"
            class="form-control"
            placeholder="Email Address"
            required>
    </div>

    <div class="mb-3">
        <input
            type="text"
            name="subject"
            class="form-control"
            placeholder="Subject"
            required>
    </div>

    <div class="mb-3">
        <textarea
            name="message"
            class="form-control"
            rows="5"
            placeholder="Your Message"
            required></textarea>
    </div>

    <button
        class="btn btn-success"
        type="submit">

        Send Message

    </button>

</form>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>