<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Login | JC Barley Website</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<link rel="stylesheet"
href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

<link rel="stylesheet" href="assets/css/auth.css">

</head>

<body>

<div class="watermarks">

    <img src="assets/images/logo.png" alt="">
    <img src="assets/images/logo.png" alt="">
    <img src="assets/images/logo.png" alt="">
    <img src="assets/images/logo.png" alt="">
    <img src="assets/images/logo.png" alt="">
    <img src="assets/images/logo.png" alt="">
    <img src="assets/images/logo.png" alt="">
    <img src="assets/images/logo.png" alt="">
    <img src="assets/images/logo.png" alt="">
    <img src="assets/images/logo.png" alt="">
    <img src="assets/images/logo.png" alt="">
    <img src="assets/images/logo.png" alt="">
    <img src="assets/images/logo.png" alt="">
    <img src="assets/images/logo.png" alt="">
    <img src="assets/images/logo.png" alt="">
    <img src="assets/images/logo.png" alt="">
    <img src="assets/images/logo.png" alt="">
    <img src="assets/images/logo.png" alt="">
    <img src="assets/images/logo.png" alt="">
    <img src="assets/images/logo.png" alt="">
    <img src="assets/images/logo.png" alt="">
    <img src="assets/images/logo.png" alt="">
    <img src="assets/images/logo.png" alt="">
    <img src="assets/images/logo.png" alt="">
    <img src="assets/images/logo.png" alt="">
    <img src="assets/images/logo.png" alt="">
    <img src="assets/images/logo.png" alt="">
    <img src="assets/images/logo.png" alt="">
    <img src="assets/images/logo.png" alt="">
    <img src="assets/images/logo.png" alt="">
    <img src="assets/images/logo.png" alt="">
    <img src="assets/images/logo.png" alt="">
    <img src="assets/images/logo.png" alt="">
    <img src="assets/images/logo.png" alt="">
    <img src="assets/images/logo.png" alt="">
    <img src="assets/images/logo.png" alt="">
    <img src="assets/images/logo.png" alt="">
    <img src="assets/images/logo.png" alt="">
    <img src="assets/images/logo.png" alt="">

</div>

<div class="container">

    <div class="row g-0">

        <div class="col-lg-5">

            <div class="left-side">

<img
src="assets/images/logo.png"
alt="JC Barley Logo"
style="
width:180px;
filter:drop-shadow(0 10px 30px rgba(0,0,0,.30));
position:relative;
z-index:2;
">

<h2 class="mt-3">

Barley Business

</h2>

<p>

Welcome back to your professional dashboard.
Manage your achievements, gallery,
customer messages, and website settings
securely from one place.

</p>

<hr>

<div class="feature">

<i class="bi bi-shield-lock-fill"></i>

Secure Login

</div>

<div class="feature">

<i class="bi bi-trophy-fill"></i>

Achievements Management

</div>

<div class="feature">

<i class="bi bi-images"></i>

Gallery Management

</div>

<div class="feature">

<i class="bi bi-envelope-fill"></i>

Customer Messages

</div>

</div>

</div>

<!-- RIGHT SIDE -->

<div class="col-lg-7">

<div class="right-side">

<h3 class="fw-bold mb-2">
    Welcome Back
</h3>

<p class="text-muted mb-4">
    Sign in to your account to continue.
</p>

<?php if(isset($_GET['error']) && $_GET['error'] == 'invalid'): ?>
<div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
    <i class="bi bi-exclamation-triangle-fill"></i>
    Invalid username/email or password.
    <button type="button"
            class="btn-close"
            data-bs-dismiss="alert"></button>
</div>
<?php endif; ?>

<?php if(isset($_GET['registered'])): ?>
<div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
    <i class="bi bi-check-circle-fill"></i>
    Registration successful! You can now login.
    <button type="button"
            class="btn-close"
            data-bs-dismiss="alert"></button>
</div>
<?php endif; ?>

<form action="auth/login.php" method="POST">

    <div class="mb-3">

        <label class="form-label">

            Username or Email

        </label>

        <input
            type="text"
            name="login"
            class="form-control"
            placeholder="Enter your username or email"
            required>

    </div>

    <div class="mb-3">

        <label class="form-label">

            Password

        </label>

        <input
            type="password"
            name="password"
            class="form-control"
            placeholder="Enter your password"
            required>

    </div>

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div class="form-check">

    <input
        class="form-check-input"
        type="checkbox"
        name="remember"
        id="remember">

    <label
        class="form-check-label"
        for="remember">

        Remember Me

    </label>

</div>

        <a
    href="forgot-password.php"
    class="text-success text-decoration-none fw-semibold">

    Forgot Password?

</a>

    </div>

    <div class="d-grid">

        <button
            type="submit"
            class="btn btn-success">

            <i class="bi bi-box-arrow-in-right"></i>

            Login

        </button>

    </div>

    <div class="text-center mt-4">

        Don't have an account?

        <a
            href="register.php"
            class="text-success fw-bold text-decoration-none">

            Create Account

        </a>

    </div>


</form>
</div>

</div>

</div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>