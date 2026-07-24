<?php

require 'config/database.php';

$stmt = $conn->prepare("
    SELECT *
    FROM achievements
    ORDER BY award_date DESC
");

$stmt->execute();

$achievements = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">

<meta name="viewport"
content="width=device-width, initial-scale=1.0">

<title>All Achievements</title>

<link rel="stylesheet"
href="assets/css/style.css">

</head>

<body>

<header>

<div class="logo">

<img
src="assets/images/logo.png"
alt="Logo">

<h2>JC Barley Business</h2>

</div>

<nav>

<ul>

<li><a href="index.php">Home</a></li>

<li><a href="achievements.php">Achievements</a></li>

</ul>

</nav>

</header>

<section class="achievement" style="margin-top:100px;">

<h2>All Achievements</h2>

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

<footer>

<p>

© 2026 JC Barley Business. All Rights Reserved.

</p>

</footer>

</body>

</html>