<?php

require '../../config/session.php';
require '../../config/database.php';

if(!isset($_SESSION['user_id'])){
    header("Location: ../../login.php");
    exit;
}

$stmt = $conn->prepare("
SELECT *
FROM testimonials
WHERE owner_id = :owner
ORDER BY created_at DESC
");

$stmt->execute([
    ':owner' => $_SESSION['user_id']
]);

$testimonials = $stmt->fetchAll(PDO::FETCH_ASSOC);

include '../../includes/header.php';
include '../../includes/sidebar.php';
include '../../includes/navbar.php';

?>

<div class="main-content">

<div class="content">

<div class="container-fluid">

<div class="d-flex justify-content-between align-items-center mb-4">

<h2 class="fw-bold">

Testimonials

</h2>

<a
href="create.php"
class="btn btn-success">

<i class="bi bi-plus-circle"></i>

Add Testimonial

</a>

</div>

<?php if(isset($_GET['updated'])): ?>

<div class="alert alert-success alert-dismissible fade show">

    Testimonial updated successfully.

    <button
        type="button"
        class="btn-close"
        data-bs-dismiss="alert">
    </button>

</div>

<?php endif; ?>

<div class="card shadow">

<div class="card-body">

<table class="table table-bordered table-hover align-middle">

<thead>

<tr>

<th width="90">Photo</th>

<th>Name</th>

<th>Position</th>

<th>Message</th>

<th width="170">Action</th>

</tr>

</thead>

<tbody>

<?php if(count($testimonials)>0): ?>

<?php foreach($testimonials as $row): ?>

<tr>

<td>

<img
src="../../uploads/testimonials/<?= htmlspecialchars($row['image']) ?>"
style="width:70px;height:70px;object-fit:cover;border-radius:10px;">

</td>

<td>

<?= htmlspecialchars($row['fullname']) ?>

</td>

<td>

<?= htmlspecialchars($row['position']) ?>

</td>

<td>

<?= nl2br(htmlspecialchars($row['message'])) ?>

</td>

<td>

<a
href="edit.php?id=<?= $row['id'] ?>"
class="btn btn-primary btn-sm">

Edit

</a>

<a
href="../../auth/delete_testimonials.php?id=<?= $row['id'] ?>"
class="btn btn-danger btn-sm"
onclick="return confirm('Delete this testimonial?')">

Delete

</a>

</td>

</tr>

<?php endforeach; ?>

<?php else: ?>

<tr>

<td colspan="5" class="text-center">

No testimonials yet.

</td>

</tr>

<?php endif; ?>

</tbody>

</table>

</div>

</div>

</div>

</div>

</div>

<?php include '../../includes/footer.php'; ?>