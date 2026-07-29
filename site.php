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

$heroImage = null;
$aboutImage = null;

foreach($galleryImages as $img){

    if($img['section']=="hero" && $heroImage==null){
        $heroImage=$img;
    }

    if($img['section']=="about" && $aboutImage==null){
        $aboutImage=$img;
    }

}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
<?= htmlspecialchars($settings['website_name'] ?? $ownerName) ?>
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

<?php if($heroImage): ?>

style="
background-image:url('uploads/gallery/<?= htmlspecialchars($heroImage['image']) ?>');
background-size:cover;
background-position:center;
"

<?php endif; ?>

>

        <h1>
<?= htmlspecialchars(
    !empty($settings['hero_title'])
        ? $settings['hero_title']
        : 'Empowering Success Through JC Barley Business'
) ?>
</h1>


        <p>
Discover inspiring achievements, successful members, and the journey of building a better future together.
</p>

        <a href="#achievements" class="btn">
    View Achievements
</a>

    </section>

    <!-- About Section -->
    <section id="about" class="about">

        <div class="about-text">

           <h2>

<?= htmlspecialchars(
$settings['about_title']
?? 'About JC Barley Business'
) ?>

</h2>

<p>

<?= nl2br(htmlspecialchars(
$settings['about_description']
?? 'JC Barley Business is committed to empowering individuals by providing opportunities for personal growth, financial success, and entrepreneurship.'
)) ?>

</p>
        </div>

        <div class="about-image">

            <?php if($aboutImage): ?>

<img
src="uploads/gallery/<?= htmlspecialchars($aboutImage['image']) ?>"
alt="About">

<?php else: ?>

<img
src="assets/images/about.jpg"
alt="About">

<?php endif; ?>
        </div>

    </section>

    <!-- Statistics Section -->
    <section class="stats">

        <div class="stat-box">
            <h2>10+</h2>
            <p>Years in Business</p>
        </div>

        <div class="stat-box">
            <h2>5,000+</h2>
            <p>Happy Members</p>
        </div>

        <div class="stat-box">
            <h2>100+</h2>
            <p>Awards Received</p>
        </div>

        <div class="stat-box">
            <h2>1,000+</h2>
            <p>Success Stories</p>
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

    <!-- Testimonials Section -->
    <section class="testimonials">

        <h2>What Our Members Say</h2>

        <div class="testimonial-container">

            <div class="testimonial-card">

                <img src="assets/images/person1.jpg" alt="Member">

                <h3>Maria Santos</h3>

                <p>
                    "JC Barley Business changed my life. I gained confidence,
                    financial opportunities, and lifelong friends."
                </p>

            </div>

            <div class="testimonial-card">

                <img src="assets/images/person2.jpg" alt="Member">

                <h3>Juan Dela Cruz</h3>

                <p>
                    "The support from the community inspired me to reach
                    my goals and help others succeed."
                </p>

            </div>

            <div class="testimonial-card">

                <img src="assets/images/person3.jpg" alt="Member">

                <h3>Ana Reyes</h3>

                <p>
                    "Every recognition motivates me to work harder and
                    become a better leader."
                </p>

            </div>

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

<!-- AI Chat Button -->
<div id="chat-button">
    💬
</div>

<!-- AI Chat Box -->
<div id="chat-box">

    <div class="chat-header">
        JC Barley AI Assistant
    </div>

    <div id="chat-messages">

        <div class="bot">
            👋 Hello!

            Welcome to our website.

            I'm here to answer your questions and help you learn more about our products and services.

            How may I assist you today?
        </div>

    </div>

    <div class="chat-input">

        <input
            type="text"
            id="message"
            placeholder="Type your message...">

        <button id="sendBtn">
            Send
        </button>

    </div>

</div>

<link rel="stylesheet" href="chat/style.css">

<script>

window.ownerId = <?= $ownerId ?>;

</script>

<script src="chat/script.js"></script>

<!-- Gallery Lightbox -->

<div id="galleryModal" class="gallery-modal">

    <span id="closeGallery">&times;</span>

    <img id="galleryPreview">

</div>

</body>

</html>