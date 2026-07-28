<?php

require_once __DIR__ . '/../config/session.php';
require_once __DIR__ . '/../config/app.php';

if (!isset($_SESSION['user_id'])) {

    header("Location: " . BASE_URL . "/login.php");
    exit;

}

$pageTitle = $pageTitle ?? "Dashboard";

?>

<!DOCTYPE html>

<html lang="en">

<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1">

<title><?= htmlspecialchars($pageTitle) ?> | JC Barley Business</title>

<link
href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
rel="stylesheet">

<link
rel="stylesheet"
href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

<link
rel="stylesheet"
href="<?= BASE_URL ?>/assets/css/dashboard.css">

</head>

<body class="dashboard-body">