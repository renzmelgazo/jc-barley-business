<?php

require_once __DIR__ . '/../config/app.php';

$navProfileImage = !empty($_SESSION['profile_picture'])
    ? BASE_URL . "/uploads/profiles/" . $_SESSION['profile_picture']
    : BASE_URL . "/assets/images/default-avatar.png";

?>

<nav class="navbar navbar-expand-lg bg-white shadow-sm px-4">

    <div class="container-fluid">

        <div>

            <h5 class="mb-0 fw-bold text-success">
                JC Barley Business
            </h5>

            <small class="text-muted">
                Dashboard
            </small>

        </div>

        <div class="dropdown">

            <a
                href="#"
                class="text-decoration-none text-dark d-flex align-items-center"
                data-bs-toggle="dropdown">

                <div class="position-relative me-3">

                    <img
                        src="<?= $navProfileImage ?>"
                        alt="Profile Picture"
                        class="rounded-circle shadow-sm"
                        style="
                            width:48px;
                            height:48px;
                            object-fit:cover;
                            border:2px solid #198754;
                        ">

                    <!-- Online Status -->
                    <span
                        class="position-absolute bottom-0 end-0 bg-success border border-white rounded-circle"
                        style="
                            width:13px;
                            height:13px;
                        ">
                    </span>

                </div>

                <div class="text-start">

                    <div class="fw-bold">

                        <?= htmlspecialchars($_SESSION['fullname']) ?>

                    </div>

                    <small class="text-muted">

                        Administrator

                    </small>

                </div>

                <i class="bi bi-chevron-down ms-3"></i>

            </a>

            <ul class="dropdown-menu dropdown-menu-end shadow">

                <li>

                    <a
                        class="dropdown-item"
                        href="<?= DASHBOARD_URL ?>/profile.php">

                        <i class="bi bi-person-circle me-2"></i>

                        My Profile

                    </a>

                </li>

                <li>

                    <a
                        class="dropdown-item"
                        href="<?= DASHBOARD_URL ?>/settings.php">

                        <i class="bi bi-gear me-2"></i>

                        Settings

                    </a>

                </li>

                <li>

                    <hr class="dropdown-divider">

                </li>

                <li>

                    <a
                        class="dropdown-item text-danger"
                        href="<?= BASE_URL ?>/logout.php">

                        <i class="bi bi-box-arrow-right me-2"></i>

                        Logout

                    </a>

                </li>

            </ul>

        </div>

    </div>

</nav>