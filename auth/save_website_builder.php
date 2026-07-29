<?php

require '../config/session.php';
require '../config/database.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit;
}

$ownerId = $_SESSION['user_id'];

$hero_title = trim($_POST['hero_title']);
$hero_description = trim($_POST['hero_description']);
$hero_button_text = trim($_POST['hero_button_text']);
$hero_button_link = trim($_POST['hero_button_link']);
$hero_text_color = trim($_POST['hero_text_color']);

$about_title = trim($_POST['about_title']);
$about_description = trim($_POST['about_description']);
$about_text_color = trim($_POST['about_text_color']);

/*
|--------------------------------------------------------------------------
| Get Current Images
|--------------------------------------------------------------------------
*/

$stmt = $conn->prepare("
SELECT hero_image,about_image
FROM website_settings
WHERE owner_id=:owner
LIMIT 1
");

$stmt->execute([
    ':owner'=>$ownerId
]);

$current = $stmt->fetch(PDO::FETCH_ASSOC);

$hero_image = $current['hero_image'];
$about_image = $current['about_image'];

/*
|--------------------------------------------------------------------------
| Upload Folder
|--------------------------------------------------------------------------
*/

$uploadDir = "../uploads/website/";

if(!is_dir($uploadDir)){
    mkdir($uploadDir,0777,true);
}

/*
|--------------------------------------------------------------------------
| Upload Hero Image
|--------------------------------------------------------------------------
*/

if(isset($_FILES['hero_image']) && $_FILES['hero_image']['error']==0){

    $ext = strtolower(pathinfo($_FILES['hero_image']['name'],PATHINFO_EXTENSION));

    $hero_image = uniqid().".".$ext;

    move_uploaded_file(
        $_FILES['hero_image']['tmp_name'],
        $uploadDir.$hero_image
    );

}

/*
|--------------------------------------------------------------------------
| Upload About Image
|--------------------------------------------------------------------------
*/

if(isset($_FILES['about_image']) && $_FILES['about_image']['error']==0){

    $ext = strtolower(pathinfo($_FILES['about_image']['name'],PATHINFO_EXTENSION));

    $about_image = uniqid().".".$ext;

    move_uploaded_file(
        $_FILES['about_image']['tmp_name'],
        $uploadDir.$about_image
    );

}

/*
|--------------------------------------------------------------------------
| Update Website
|--------------------------------------------------------------------------
*/

$stmt = $conn->prepare("
UPDATE website_settings
SET

hero_image=:hero_image,
hero_title=:hero_title,
hero_description=:hero_description,
hero_button_text=:hero_button_text,
hero_button_link=:hero_button_link,
hero_text_color=:hero_text_color,

about_image=:about_image,
about_title=:about_title,
about_description=:about_description,
about_text_color=:about_text_color

WHERE owner_id=:owner
");

$stmt->execute([

':hero_image'=>$hero_image,
':hero_title'=>$hero_title,
':hero_description'=>$hero_description,
':hero_button_text'=>$hero_button_text,
':hero_button_link'=>$hero_button_link,
':hero_text_color'=>$hero_text_color,

':about_image'=>$about_image,
':about_title'=>$about_title,
':about_description'=>$about_description,
':about_text_color'=>$about_text_color,

':owner'=>$ownerId

]);

header("Location: ../dashboard/website-builder/index.php?success=1");
exit;