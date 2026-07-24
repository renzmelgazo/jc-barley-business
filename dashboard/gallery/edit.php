<?php

require '../../config/session.php';
require '../../config/database.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../../login.php");
    exit;
}

if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit;
}

$stmt = $conn->prepare("
    SELECT *
    FROM gallery
    WHERE id = :id
");

$stmt->execute([
    ':id' => $_GET['id']
]);

$gallery = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$gallery) {
    die("Gallery image not found.");
}

include '../../includes/header.php';
include '../../includes/navbar.php';

?>

<div class="d-flex">

<?php include '../../includes/sidebar.php'; ?>

<div class="container-fluid p-4">

<h2 class="mb-4">Edit Gallery</h2>

<div class="card shadow">

<div class="card-body">

<form
action="../../auth/update_gallery.php"
method="POST"
enctype="multipart/form-data">

<input
type="hidden"
name="id"
value="<?= $gallery['id'] ?>">

<input
type="hidden"
name="old_image"
value="<?= $gallery['image'] ?>">

<div class="mb-3">

<label class="form-label">
Title
</label>

<input
type="text"
name="title"
class="form-control"
value="<?= htmlspecialchars($gallery['title']) ?>"
required>

</div>

<div class="mb-3">

<label class="form-label">
Description
</label>

<textarea
name="description"
class="form-control"
rows="4"><?= htmlspecialchars($gallery['description']) ?></textarea>

</div>

<div class="mb-3">

<label class="form-label">
Current Image
</label>

<br>

<img
src="../../uploads/gallery/<?= $gallery['image'] ?>"
width="250"
class="rounded shadow">

</div>

<div class="mb-3">

<label class="form-label">
Replace Image (Optional)
</label>

<input
type="file"
name="image"
class="form-control"
accept=".jpg,.jpeg,.png,.webp">

</div>

<button
type="submit"
class="btn btn-primary">

Update Gallery

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

<?php include '../../includes/footer.php'; ?>