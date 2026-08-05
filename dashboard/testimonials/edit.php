<?php

require '../../config/session.php';
require '../../config/database.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../../login.php");
    exit;
}

if (!isset($_GET['id'])) {
    die("Invalid testimonial.");
}

$id = (int)$_GET['id'];

$stmt = $conn->prepare("
SELECT *
FROM testimonials
WHERE id = :id
AND owner_id = :owner
LIMIT 1
");

$stmt->execute([
    ':id' => $id,
    ':owner' => $_SESSION['user_id']
]);

$testimonial = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$testimonial) {
    die("Testimonial not found.");
}

include '../../includes/header.php';
include '../../includes/sidebar.php';
include '../../includes/navbar.php';
?>

<div class="main-content">

<div class="content">

<div class="container-fluid">

<h2 class="fw-bold mb-4">
Edit Testimonial
</h2>

<form
action="../../auth/update_testimonials.php"
method="POST"
enctype="multipart/form-data">

<input
type="hidden"
name="id"
value="<?= $testimonial['id'] ?>">

<input
type="hidden"
name="old_image"
value="<?= htmlspecialchars($testimonial['image']) ?>">

<div class="card shadow">

<div class="card-body">

<label class="form-label">
Photo
</label>

<br>

<img
src="../../uploads/testimonials/<?= htmlspecialchars($testimonial['image']) ?>"
style="width:120px;height:120px;object-fit:cover;border-radius:10px">

<br><br>

<input
type="file"
name="image"
class="form-control">

<br>

<label class="form-label">
Full Name
</label>

<input
type="text"
name="fullname"
class="form-control"
value="<?= htmlspecialchars($testimonial['fullname']) ?>">

<br>

<label class="form-label">
Position
</label>

<input
type="text"
name="position"
class="form-control"
value="<?= htmlspecialchars($testimonial['position']) ?>">

<br>

<label class="form-label">
Message
</label>

<textarea
name="message"
rows="6"
class="form-control"><?= htmlspecialchars($testimonial['message']) ?></textarea>

<br>

<button class="btn btn-success">
Save Changes
</button>

<a
href="index.php"
class="btn btn-secondary">
Cancel
</a>

</div>

</div>

</form>

</div>

</div>

</div>

<?php include '../../includes/footer.php'; ?>