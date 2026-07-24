<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
</head>
<body>

<h1>Create Account</h1>

<form action="auth/register.php" method="POST">

    <p>
        <label>Full Name</label><br>
        <input type="text" name="fullname" required>
    </p>

    <p>
        <label>Username</label><br>
        <input type="text" name="username" required>
    </p>

    <p>
        <label>Email</label><br>
        <input type="email" name="email" required>
    </p>

    <p>
        <label>Password</label><br>
        <input type="password" name="password" required>
    </p>

    <p>
        <label>Confirm Password</label><br>
        <input type="password" name="confirm_password" required>
    </p>

    <button type="submit">Create Account</button>

</form>

</body>
</html>