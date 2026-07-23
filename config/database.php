<?php

$host = "localhost";
$dbname = "jc_barley_db";
$username = "root";
$password = "root";

try {

    $conn = new PDO(
        "mysql:host=$host;dbname=$dbname;charset=utf8mb4",
        $username,
        $password
    );

    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch (PDOException $e) {

    die("Connection Failed: " . $e->getMessage());

}

?>