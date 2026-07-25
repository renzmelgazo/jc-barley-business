<?php

require '../../config/session.php';
require '../../config/database.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../../login.php");
    exit;
}

$stmt = $conn->prepare("
    SELECT *
    FROM website_settings
    WHERE owner_id = :owner_id
");

$stmt->execute([
    ':owner_id' => $_SESSION['user_id']
]);

$settings = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$settings) {
    die("Website settings not found.");
}

include '../../includes/header.php';
include '../../includes/navbar.php';

?>

<div class="d-flex">

<?php include '../../includes/sidebar.php'; ?>

<div class="container-fluid p-4">

<div class="card shadow">

<div class="card-header bg-success text-white">

<h3>Edit Website Settings</h3>

</div>

<div class="card-body">

<form
action="../../auth/update_website_settings.php"
method="POST">

<div class="mb-3">

<label>Website Name</label>

<input
type="text"
name="website_name"
class="form-control"
value="<?= htmlspecialchars($settings['website_name']) ?>"
required>

</div>

<div class="mb-3">

<label>Tagline</label>

<input
type="text"
name="tagline"
class="form-control"
value="<?= htmlspecialchars($settings['tagline']) ?>">

</div>

<div class="mb-3">

<label>About</label>

<textarea
name="about"
rows="5"
class="form-control"><?= htmlspecialchars($settings['about']) ?></textarea>

</div>

<div class="mb-3">

<label>Contact Number</label>

<input
type="text"
name="contact_number"
class="form-control"
value="<?= htmlspecialchars($settings['contact_number']) ?>">

</div>

<div class="mb-3">

<label>Email</label>

<input
type="email"
name="email"
class="form-control"
value="<?= htmlspecialchars($settings['email']) ?>">

</div>

<div class="mb-3">

<label>Facebook</label>

<input
type="text"
name="facebook"
class="form-control"
value="<?= htmlspecialchars($settings['facebook']) ?>">

</div>

<button
class="btn btn-success"
type="submit">

Save Changes

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