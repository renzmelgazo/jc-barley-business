<?php

require '../../config/session.php';

if(!isset($_SESSION['user_id'])){
    header("Location: ../../login.php");
    exit;
}

$pageTitle="Add Gallery";

include '../../includes/header.php';
include '../../includes/sidebar.php';
?>

<div class="main-content">

<?php include '../../includes/navbar.php'; ?>

<div class="content">

<div class="dashboard-card">

<h2 class="fw-bold mb-4">

<i class="bi bi-images text-success"></i>

Add Gallery Image

</h2>

<form
action="../../auth/save_gallery.php"
method="POST"
enctype="multipart/form-data">

<div class="row">

<div class="col-md-6">

<label class="form-label">

Image Title

</label>

<input
type="text"
name="title"
class="form-control form-control-lg"
required>

</div>

<div class="col-md-6">

<label class="form-label">

Website Section

</label>

<select
name="section"
class="form-select form-select-lg"
required>

<option value="">Select Section</option>

<option value="hero">Hero Banner</option>

<option value="about">About Section</option>

<option value="gallery">Gallery</option>

<option value="achievement">Achievement</option>

<option value="testimonial">Testimonial</option>

</select>

</div>

</div>

<div class="mt-4">

<label class="form-label">

Description

</label>

<textarea
name="description"
rows="5"
class="form-control"></textarea>

</div>

<div class="mt-4">

<label class="form-label">

Upload Image

</label>

<div class="upload-box">

<input
type="file"
id="imageInput"
name="image"
accept=".jpg,.jpeg,.png,.webp"
required>

<div id="previewArea">

<div class="upload-icon">

📷

</div>

<p>

Click here to upload image

</p>

</div>

</div>

</div>

<div class="mt-5">

<button
class="btn btn-success btn-lg">

Save Gallery

</button>

<a
href="index.php"
class="btn btn-outline-secondary btn-lg">

Cancel

</a>

</div>

</form>

</div>

</div>

</div>

<script>

const input=document.getElementById("imageInput");

const preview=document.getElementById("previewArea");

input.onchange=function(){

const file=this.files[0];

if(!file)return;

const reader=new FileReader();

reader.onload=function(e){

preview.innerHTML=`

<img
src="${e.target.result}"
style="
width:100%;
height:300px;
object-fit:cover;
border-radius:15px;
">

`;

}

reader.readAsDataURL(file);

}

</script>

<?php include '../../includes/footer.php'; ?>