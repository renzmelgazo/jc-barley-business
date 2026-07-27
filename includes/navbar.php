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

<i class="bi bi-person-circle fs-2 me-2 text-success"></i>

<div class="text-start">

<div class="fw-semibold">

<?= htmlspecialchars($_SESSION['fullname']) ?>

</div>

<small class="text-muted">

Administrator

</small>

</div>

<i class="bi bi-chevron-down ms-2"></i>

</a>

<ul class="dropdown-menu dropdown-menu-end shadow">

<li>

<a class="dropdown-item" href="profile.php">

<i class="bi bi-person me-2"></i>

Profile

</a>

</li>

<li>

<a class="dropdown-item" href="settings.php">

<i class="bi bi-gear me-2"></i>

Settings

</a>

</li>

<li><hr class="dropdown-divider"></li>

<li>

<a class="dropdown-item text-danger" href="../auth/logout.php">

<i class="bi bi-box-arrow-right me-2"></i>

Logout

</a>

</li>

</ul>

</div>

</div>

</nav>