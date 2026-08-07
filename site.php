<?php

require 'config/database.php';

if (!isset($_GET['owner']) || empty($_GET['owner'])) {
    die("Website not specified.");
}

$slug = trim($_GET['owner']);

/*
|--------------------------------------------------------------------------
| Get Website Owner
|--------------------------------------------------------------------------
*/

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

$ownerId = $owner['id'];
$ownerName = $owner['fullname'];

/*
|--------------------------------------------------------------------------
| Website Settings
|--------------------------------------------------------------------------
*/

$stmt = $conn->prepare("
    SELECT *
    FROM website_settings
    WHERE owner_id = :owner_id
    LIMIT 1
");

$stmt->execute([
    ':owner_id' => $ownerId
]);

$settings = $stmt->fetch(PDO::FETCH_ASSOC);

/*
|--------------------------------------------------------------------------
| Achievements
|--------------------------------------------------------------------------
*/

$stmt = $conn->prepare("
    SELECT *
    FROM achievements
    WHERE owner_id = :owner_id
    ORDER BY award_date DESC
    LIMIT 6
");

$stmt->execute([
    ':owner_id' => $ownerId
]);

$achievements = $stmt->fetchAll(PDO::FETCH_ASSOC);

/*
|--------------------------------------------------------------------------
| Testimonials
|--------------------------------------------------------------------------
*/

$stmt = $conn->prepare("
SELECT *
FROM testimonials
WHERE owner_id = :owner_id
ORDER BY created_at DESC
LIMIT 6
");

$stmt->execute([
    ':owner_id' => $ownerId
]);

$testimonials = $stmt->fetchAll(PDO::FETCH_ASSOC);


/*
|--------------------------------------------------------------------------
| Gallery Images
|--------------------------------------------------------------------------
*/

$stmt = $conn->prepare("
SELECT *
FROM gallery
WHERE owner_id = :owner_id
ORDER BY created_at DESC
");

$stmt->execute([
    ':owner_id' => $ownerId
]);

$galleryImages = $stmt->fetchAll(PDO::FETCH_ASSOC);


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
<?= htmlspecialchars(!empty($settings['website_name']) ? $settings['website_name'] : $ownerName) ?>
</title>

    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="chat/style.css">
</head>

<body>

    <!-- Navigation -->
    <header>

        <div class="logo">
            <img src="assets/images/logo.png" alt="Logo">
            <h2>
<?= htmlspecialchars($settings['website_name'] ?? 'JC Barley Business') ?>
</h2>
        </div>

        <nav>
    <ul>
        <li><a href="#home">Home</a></li>
        <li><a href="#about">About</a></li>
        <li><a href="#achievements">Achievements</a></li>
        <li><a href="#gallery">Gallery</a></li>
    </ul>
</nav>

    </header>

    <!-- Hero Section -->
    <section
id="home"
class="hero"

style="
background-image:url('uploads/website/<?= htmlspecialchars($settings['hero_image']) ?>');
background-size:cover;
background-position:center;
"
>

        <h1>
<span style="color:<?= htmlspecialchars($settings['hero_title_color'] ?? '#ffffff') ?>">
<?= htmlspecialchars($settings['hero_title']) ?>
</span>
</h1>


        <p style="color:<?= htmlspecialchars($settings['hero_description_color'] ?? '#ffffff') ?>">

<?= nl2br(htmlspecialchars($settings['hero_description'])) ?>

</p>

        <?php if(!empty($settings['hero_button_text'])): ?>

<a
href="<?= htmlspecialchars($settings['hero_button_link'] ?: '#') ?>"
class="btn">

<?= htmlspecialchars($settings['hero_button_text']) ?>

</a>

<?php endif; ?>

    </section>

    <!-- About Section -->
    <section id="about" class="about">

        <div class="about-text">

        <h2
style="color:<?= htmlspecialchars($settings['about_title_color'] ?? '#000000') ?>">

<?= htmlspecialchars($settings['about_title']) ?>

</h2>

<p
style="color:<?= htmlspecialchars($settings['about_description_color'] ?? '#000000') ?>">

<?= nl2br(htmlspecialchars($settings['about_description'])) ?>

</p>
        
        </div>

        <div class="about-image">

            <img
src="uploads/website/<?= htmlspecialchars($settings['about_image']) ?>"
alt="About">
        </div>

    </section>

    <!-- Statistics Section -->

<section class="stats">

    <div class="stat-box">

        <h2>
            <?= htmlspecialchars($settings['stat_years'] ?? '10+') ?>
        </h2>

        <p>Years in Business</p>

    </div>

    <div class="stat-box">

        <h2>
            <?= htmlspecialchars($settings['stat_members'] ?? '5000+') ?>
        </h2>

        <p>Happy Members</p>

    </div>

    <div class="stat-box">

        <h2>
            <?= htmlspecialchars($settings['stat_awards'] ?? '100+') ?>
        </h2>

        <p>Awards Received</p>

    </div>

    <div class="stat-box">

        <h2>
            <?= htmlspecialchars($settings['stat_success'] ?? '1000+') ?>
        </h2>

        <p>Success Stories</p>

    </div>

</section>

<!-- Testimonials Section -->

<section class="testimonials">

    <h2>What Our Members Say</h2>

    <div class="testimonial-container">

    <?php if(count($testimonials)>0): ?>

        <?php foreach($testimonials as $testimonial): ?>

            <div class="testimonial-card">

                <img
                src="uploads/testimonials/<?= htmlspecialchars($testimonial['image']) ?>"
                alt="<?= htmlspecialchars($testimonial['fullname']) ?>">

                <h3>

                    <?= htmlspecialchars($testimonial['fullname']) ?>

                </h3>

                <small>

                    <?= htmlspecialchars($testimonial['position']) ?>

                </small>

                <p>

                    <?= nl2br(htmlspecialchars($testimonial['message'])) ?>

                </p>

            </div>

        <?php endforeach; ?>

    <?php else: ?>

        <p>No testimonials available yet.</p>

    <?php endif; ?>

    </div>

</section>

    <!-- Gallery Section -->
    <section id="gallery" class="gallery">

        <h2>Our Gallery</h2>

        <p>
            Explore memorable moments, successful events, inspiring achievements,
            and the vibrant community of JC Barley Business.
        </p>

        <div class="gallery-container">

<?php if(count($galleryImages)>0): ?>

    <?php foreach($galleryImages as $image): ?>

        <img
            src="uploads/gallery/<?= htmlspecialchars($image['image']) ?>"
            alt="<?= htmlspecialchars($image['title']) ?>">

    <?php endforeach; ?>

<?php else: ?>

    <p>No gallery uploaded yet.</p>

<?php endif; ?>

</div>

    </section>


    <!-- Achievement Section -->
<section class="achievement">

    <h2>Latest Achievements</h2>

    <div class="card-container">

        <?php if(count($achievements) > 0): ?>

            <?php foreach($achievements as $achievement): ?>

                <div class="achievement-card">

                    <img
                        src="uploads/achievements/<?= htmlspecialchars($achievement['image']) ?>"
                        alt="<?= htmlspecialchars($achievement['title']) ?>">

                    <h3>
                        <?= htmlspecialchars($achievement['title']) ?>
                    </h3>

                    <p>
                        <?= htmlspecialchars($achievement['description']) ?>
                    </p>

                    <small>
                        <?= date('F d, Y', strtotime($achievement['award_date'])) ?>
                    </small>

                </div>

            <?php endforeach; ?>

        <?php else: ?>

            <p>No achievements found.</p>

        <?php endif; ?>

    </div>

</section>

    <!-- Footer -->
    <footer>

        <p>
            © 2026 JC Barley Business. All Rights Reserved.
        </p>

    </footer>

    <script src="assets/js/script.js"></script>

<!-- Chat Button -->
<div id="chat-button" type="button">
    💬
</div>

<!-- Chat Box -->
<div id="chat-box">

    <div class="chat-header">
        JC Barley Chat
    </div>

    <div id="chat-messages">

    
    </div>

    <!-- Start Chat -->
    <div id="chatStartArea">

        <button
            id="startChatBtn"
            type="button"
        >
            Start Chat
        </button>

    </div>

    <!-- Chat Input -->
    <div
        id="chatInputArea"
        class="chat-input"
        style="display:none;"
    >

        <input
            type="text"
            id="message"
            placeholder="Type your message..."
            autocomplete="off"
        >

        <button
            id="sendBtn"
            type="button"
        >
            Send
        </button>

    </div>

</div>



<script>
window.CHAT_OWNER_ID = <?= (int)$ownerId ?>;

let token = localStorage.getItem("jc_barley_visitor_token");

if (!token) {

    if (window.crypto && crypto.randomUUID) {

        token = crypto.randomUUID();

    } else {

        token =
            "visitor_" +
            Math.random().toString(36).substring(2) +
            Date.now();
    }

    localStorage.setItem(
        "jc_barley_visitor_token",
        token
    );


}

window.CHAT_VISITOR_TOKEN = token;
</script>

<script src="chat/script.js?v=123456"></script>

<script src="chat/script.js?v=123456"></script>

<!-- Gallery Lightbox -->

<div id="galleryModal" class="gallery-modal">

    <span id="closeGallery">&times;</span>

    <img id="galleryPreview">

</div>

</body>

</html>