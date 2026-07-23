<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
</head>
<body>

<h2>Login</h2>

<form action="auth/login.php" method="POST">

    <input type="text"
           name="login"
           placeholder="Username or Email"
           required>

    <br><br>

    <input type="password"
           name="password"
           placeholder="Password"
           required>

    <br><br>

    <button type="submit">Login</button>

</form>

</body>
</html>