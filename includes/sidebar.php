<?php

require_once __DIR__ . '/../config/app.php';

$currentUrl = $_SERVER['REQUEST_URI'];

?>

<div class="sidebar">

    <div class="logo">
        <h4>
            <i class="bi bi-grid-fill"></i>
            JC Barley
        </h4>
    </div>

    <a href="<?= DASHBOARD_URL ?>/index.php"
class="<?= basename($_SERVER['PHP_SELF']) == 'index.php' ? 'active' : '' ?>">

        <i class="bi bi-speedometer2"></i>
        <span>Dashboard</span>

    </a>

    <a href="<?= DASHBOARD_URL ?>/testimonials/index.php"
class="<?= strpos($currentUrl,'testimonials') !== false ? 'active' : '' ?>">

    <i class="bi bi-chat-square-quote"></i>

    <span>Testimonials</span>

</a>

    <a href="<?= DASHBOARD_URL ?>/website-builder/index.php"
       class="<?= strpos($currentUrl,'website-builder') !== false ? 'active' : '' ?>">

        <i class="bi bi-globe"></i>
        <span>Website Builder</span>

    </a>

    <a href="<?= DASHBOARD_URL ?>/achievements/index.php"
       class="<?= strpos($currentUrl,'achievements') !== false ? 'active' : '' ?>">

        <i class="bi bi-trophy"></i>
        <span>Achievements</span>

    </a>

    <a href="<?= DASHBOARD_URL ?>/gallery/index.php"
       class="<?= strpos($currentUrl,'gallery') !== false ? 'active' : '' ?>">

        <i class="bi bi-image"></i>
        <span>Gallery</span>

    </a>

    <a href="<?= DASHBOARD_URL ?>/messages/index.php"
       class="<?= strpos($currentUrl,'messages') !== false ? 'active' : '' ?>">

        <i class="bi bi-envelope"></i>
        <span>Messages</span>

    </a>

    <a href="<?= DASHBOARD_URL ?>/profile.php"
       class="<?= basename($_SERVER['PHP_SELF']) == 'profile.php' ? 'active' : '' ?>">

        <i class="bi bi-person-circle"></i>
        <span>Profile</span>

    </a>

    <a href="<?= DASHBOARD_URL ?>/settings.php"
       class="<?= basename($_SERVER['PHP_SELF']) == 'settings.php' ? 'active' : '' ?>">

        <i class="bi bi-gear-fill"></i>
        <span>Settings</span>

    </a>

    <div class="logout">

        <a href="<?= BASE_URL ?>/auth/logout.php">

            <i class="bi bi-box-arrow-right"></i>

            <span>Logout</span>

        </a>

    </div>

</div>