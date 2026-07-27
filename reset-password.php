<?php

require 'config/database.php';

$token = trim($_GET['token'] ?? '');

if ($token === '') {

    die("Invalid password reset link.");

}
?>

<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Reset Password</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body class="bg-light">

<div class="container mt-5">

<div class="row justify-content-center">

<div class="col-md-5">

<div class="card shadow">

<div class="card-body p-4">

<h3 class="mb-3">

Reset Password

</h3>

<form action="auth/reset-password.php" method="POST">

<input
type="hidden"
name="token"
value="<?= htmlspecialchars($token) ?>">

<div class="mb-3">

<label>

New Password

</label>

<input

type="password"

name="password"

class="form-control"

required>

</div>

<div class="mb-3">

<label>

Confirm Password

</label>

<input

type="password"

name="confirm_password"

class="form-control"

required>

</div>

<button
class="btn btn-success w-100">

Update Password

</button>

</form>

</div>

</div>

</div>

</div>

</div>

</body>

</html>