<?php

require '../config/session.php';
require '../config/database.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] != "POST") {
    header("Location: ../dashboard/website-settings/index.php");
    exit;
}

$website_name = trim($_POST['website_name']);
$tagline = trim($_POST['tagline']);
$about = trim($_POST['about']);
$contact_number = trim($_POST['contact_number']);
$email = trim($_POST['email']);
$facebook = trim($_POST['facebook']);

$stmt = $conn->prepare("
    UPDATE website_settings
    SET
        website_name = :website_name,
        tagline = :tagline,
        about = :about,
        contact_number = :contact_number,
        email = :email,
        facebook = :facebook,
        updated_at = NOW()
    WHERE owner_id = :owner_id
");

$stmt->execute([
    ':website_name' => $website_name,
    ':tagline' => $tagline,
    ':about' => $about,
    ':contact_number' => $contact_number,
    ':email' => $email,
    ':facebook' => $facebook,
    ':owner_id' => $_SESSION['user_id']
]);

header("Location: ../dashboard/website-settings/index.php?updated=1");
exit;