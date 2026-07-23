<?php

require '../config/session.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit;
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
</head>
<body>

<h1>Welcome, <?php echo htmlspecialchars($_SESSION['fullname']); ?>!</h1>

<p>Username: <?php echo htmlspecialchars($_SESSION['username']); ?></p>

<p>Email: <?php echo htmlspecialchars($_SESSION['email']); ?></p>

<a href="../logout.php">Logout</a>

</body>
</html>