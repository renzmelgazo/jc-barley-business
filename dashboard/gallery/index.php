<?php

require '../../config/session.php';
require '../../config/database.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../../login.php");
    exit;
}

$stmt = $conn->prepare("
SELECT *
FROM gallery
WHERE owner_id = :owner_id
ORDER BY created_at DESC
");

$stmt->execute([
    ':owner_id' => $_SESSION['user_id']
]);

$gallery = $stmt->fetchAll(PDO::FETCH_ASSOC);

$pageTitle = "Gallery";

include '../../includes/header.php';

?>

<?php include '../../includes/sidebar.php'; ?>

<div class="main-content">

<?php include '../../includes/navbar.php'; ?>

<div class="content">

<div class="dashboard-card">

<div class="d-flex justify-content-between align-items-center mb-4">

<h2 class="fw-bold mb-0">



Gallery Management

</h2>

<a href="create.php" class="btn btn-success">

<i class="bi bi-plus-circle"></i>

Add Image

</a>

</div>

<div class="table-responsive">

<table class="table table-hover align-middle">

<thead class="table-success">

<tr>

<th width="80">ID</th>

<th width="150">Image</th>

<th>Title</th>

<th>Description</th>

<th width="180">Actions</th>

</tr>

</thead>

<tbody>

<?php if(count($gallery)>0): ?>

<?php foreach($gallery as $row): ?>

<tr>

<td><?= $row['id'] ?></td>

<td>

<img
src="../../uploads/gallery/<?= htmlspecialchars($row['image']) ?>"
class="img-thumbnail"
style="width:120px;height:80px;object-fit:cover;">

</td>

<td>

<?= htmlspecialchars($row['title']) ?>

</td>

<td>

<?= htmlspecialchars($row['description']) ?>

</td>

<td>

<a
href="edit.php?id=<?= $row['id'] ?>"
class="btn btn-primary btn-sm">

<i class="bi bi-pencil-square"></i>

Edit

</a>

<a
href="../../auth/delete_gallery.php?id=<?= $row['id'] ?>"
class="btn btn-danger btn-sm"
onclick="return confirm('Delete this image?')">

<i class="bi bi-trash"></i>

Delete

</a>

</td>

</tr>

<?php endforeach; ?>

<?php else: ?>

<tr>

<td colspan="5" class="text-center">

No gallery images found.

</td>

</tr>

<?php endif; ?>

</tbody>

</table>

</div>

</div>

</div>

</div>

<?php include '../../includes/footer.php'; ?>