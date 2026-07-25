<?php

require '../../config/session.php';
require '../../config/database.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../../login.php");
    exit;
}

/*
|--------------------------------------------------------------------------
| Get Website Settings
|--------------------------------------------------------------------------
*/

$stmt = $conn->prepare("
    SELECT *
    FROM website_settings
    WHERE owner_id = :owner_id
");

$stmt->execute([
    ':owner_id' => $_SESSION['user_id']
]);

$settings = $stmt->fetch(PDO::FETCH_ASSOC);

include '../../includes/header.php';
include '../../includes/navbar.php';

?>

<div class="d-flex">

<?php include '../../includes/sidebar.php'; ?>

<div class="container-fluid p-4">

<div class="d-flex justify-content-between align-items-center mb-4">

    <h2>

        Website Settings

    </h2>

    <a
        href="edit.php"
        class="btn btn-success">

        Edit Settings

    </a>

</div>

<?php if(!$settings): ?>

<div class="alert alert-warning">

No website settings found.

</div>

<?php else: ?>

<div class="card shadow">

<div class="card-body">

<table class="table table-bordered">

<tr>
<th width="220">Website Name</th>
<td><?= htmlspecialchars($settings['website_name']) ?></td>
</tr>

<tr>
<th>Tagline</th>
<td><?= htmlspecialchars($settings['tagline']) ?></td>
</tr>

<tr>
<th>Contact Number</th>
<td><?= htmlspecialchars($settings['contact_number']) ?></td>
</tr>

<tr>
<th>Email</th>
<td><?= htmlspecialchars($settings['email']) ?></td>
</tr>

<tr>
<th>Facebook</th>
<td><?= htmlspecialchars($settings['facebook']) ?></td>
</tr>

<tr>
<th>Theme Color</th>
<td><?= htmlspecialchars($settings['theme_color']) ?></td>
</tr>

</table>

</div>

</div>

<?php endif; ?>

</div>

</div>

<?php include '../../includes/footer.php'; ?>