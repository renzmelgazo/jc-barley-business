<?php

require_once __DIR__ . '/../config/session.php';

if (!isset($_SESSION['user_id'])) {

    header("Location: ../login.php");

    exit;

}
?>

<!DOCTYPE html>

<html lang="en">

<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1">

<title>JC Barley Business Dashboard</title>

<link
href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
rel="stylesheet">

<link
rel="stylesheet"
href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

<link
rel="stylesheet"
href="/jc-barley-website/assets/css/dashboard.css">

</head>

<body class="dashboard-body">