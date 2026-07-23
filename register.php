<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $fullname = trim($_POST['fullname']);
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Check empty fields
    if (
        empty($fullname) ||
        empty($username) ||
        empty($email) ||
        empty($password) ||
        empty($confirm_password)
    ) {

        echo "All fields are required.";

    }

    // Check password match
    elseif ($password != $confirm_password) {

        echo "Passwords do not match.";

    }

    else {

        echo "Validation Passed!";

    }

}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
</head>

<body>

<h1>Create Account</h1>

<form action="" method="POST">

    <p>
        <label>Full Name</label><br>
        <input type="text" name="fullname">
    </p>

    <p>
        <label>Username</label><br>
        <input type="text" name="username">
    </p>

    <p>
        <label>Email</label><br>
        <input type="email" name="email">
    </p>

    <p>
        <label>Password</label><br>
        <input type="password" name="password">
    </p>

    <p>
        <label>Confirm Password</label><br>
        <input type="password" name="confirm_password">
    </p>

    <button type="submit">
        Create Account
    </button>

</form>

</body>
</html>