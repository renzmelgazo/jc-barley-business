<?php
$currentUrl = $_SERVER['REQUEST_URI'];
?>

<div class="sidebar">

    <div class="logo">
        <h4>
            <i class="bi bi-grid-fill"></i>
            JC Barley
        </h4>
    </div>

    <a href="../dashboard/index.php"
class="<?= strpos($currentUrl,'/dashboard/index.php') !== false ? 'active' : '' ?>">
        <i class="bi bi-speedometer2"></i>
        <span>Dashboard</span>
    </a>

    <a href="../website-settings/index.php">
        <i class="bi bi-globe"></i>
        <span>Website Builder</span>
    </a>

    <a href="/jc-barley-website/dashboard/achievements/index.php"
class="<?= strpos($_SERVER['REQUEST_URI'], '/dashboard/achievements') !== false ? 'active' : '' ?>">
        <i class="bi bi-trophy"></i>
        <span>Achievements</span>
    </a>

    <a href="../gallery/index.php">
        <i class="bi bi-image"></i>
        <span>Gallery</span>
    </a>

    <a href="../messages/index.php">
        <i class="bi bi-envelope"></i>
        <span>Messages</span>
    </a>

    <a href="../profile.php">
        <i class="bi bi-person-circle"></i>
        <span>Profile</span>
    </a>

    <a href="../settings.php">
        <i class="bi bi-gear-fill"></i>
        <span>Settings</span>
    </a>

    <div class="logout">

    <a href="../logout.php">

        <i class="bi bi-box-arrow-right"></i>

        <span>Logout</span>

    </a>

</div>

</div>