<?php

require '../../config/session.php';
require '../../config/database.php';

if(!isset($_SESSION['user_id'])){
    header("Location: ../../login.php");
    exit;
}

include '../../includes/header.php';
include '../../includes/sidebar.php';
include '../../includes/navbar.php';

?>

<div class="main-content">

<div class="content">

<div class="container-fluid">

<h2 class="fw-bold mb-4">

➕ Add Testimonial

</h2>

<div class="card shadow">

<div class="card-body">

<form
action="../../auth/save_testimonials.php"
method="POST"
enctype="multipart/form-data">

<div class="mb-3">

<label class="form-label">

Full Name

</label>

<input
type="text"
name="fullname"
class="form-control"
required>

</div>

<div class="mb-3">

<label class="form-label">

Position

</label>

<input
type="text"
name="position"
class="form-control"
placeholder="Example: Business Owner">

</div>

<div class="mb-3">

<label class="form-label">

Message

</label>

<textarea
name="message"
rows="5"
class="form-control"
required></textarea>

</div>

<div class="mb-3">

<label class="form-label">

Photo

</label>

<input
type="file"
name="image"
class="form-control"
accept=".jpg,.jpeg,.png,.webp"
required>

</div>

<button
class="btn btn-success">

Save Testimonial

</button>

<a
href="index.php"
class="btn btn-secondary">

Cancel

</a>

</form>

</div>

</div>

</div>

</div>

</div>

<?php include '../../includes/footer.php'; ?>