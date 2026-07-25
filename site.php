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

<div class="container py-5">

<h1 class="mb-3">
<?= htmlspecialchars($settings['website_name'] ?: $ownerName) ?>
</h1>

<p class="text-muted">
<?= htmlspecialchars($settings['tagline']) ?>
</p>

<hr>

<h3>About</h3>

<p>

<?= nl2br(htmlspecialchars($settings['about'])) ?>

</p>

<hr>

<h3>Achievements</h3>

<?php foreach($achievements as $row): ?>

<div class="card mb-3">

<div class="card-body">

<h5><?= htmlspecialchars($row['title']) ?></h5>

<p><?= htmlspecialchars($row['description']) ?></p>

</div>

</div>

<?php endforeach; ?>

<hr>

<h3>Gallery</h3>

<div class="row">

<?php foreach($gallery as $row): ?>

<div class="col-md-3 mb-4">

<img
src="uploads/gallery/<?= htmlspecialchars($row['image']) ?>"
class="img-fluid rounded">

<p class="mt-2">
<?= htmlspecialchars($row['title']) ?>
</p>

</div>

<?php endforeach; ?>

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

<h3>Contact <?= htmlspecialchars($ownerName) ?></h3>

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

</body>

</html>