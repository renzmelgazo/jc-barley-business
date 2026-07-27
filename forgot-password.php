<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">

<meta name="viewport"
content="width=device-width, initial-scale=1">

<title>Forgot Password</title>

<link
href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
rel="stylesheet">

</head>

<body class="bg-light">

<div class="container">

<div class="row justify-content-center mt-5">

<div class="col-md-5">

<div class="card shadow">

<div class="card-body p-4">

<h3 class="mb-3">

Forgot Password

</h3>

<p class="text-muted">

Enter your registered email address.

</p>

<form
action="auth/forgot-password.php"
method="POST">

<div class="mb-3">

<label>Email Address</label>

<input
type="email"
name="email"
class="form-control"
required>

</div>

<button
class="btn btn-success w-100">

Send Reset Link

</button>

</form>

<div class="text-center mt-3">

<a href="login.php">

Back to Login

</a>

</div>

</div>

</div>

</div>

</div>

</div>

</body>

</html>