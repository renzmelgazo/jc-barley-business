<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">

<meta name="viewport"
      content="width=device-width, initial-scale=1.0">

<title>Create Account | JC Barley Website</title>

<link
href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
rel="stylesheet">

<link
rel="stylesheet"
href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

<style>

    

body{
    margin:0;
    padding:0;
    min-height:100vh;

    display:flex;
    justify-content:center;
    align-items:center;

    font-family:'Poppins',sans-serif;

    overflow:hidden;
    position:relative;

    background:
    radial-gradient(circle at top left,#f7ffd8 0%,transparent 35%),
    radial-gradient(circle at bottom right,#b9e65a 0%,transparent 30%),
    linear-gradient(
        135deg,
        #d9f7ba 0%,
        #8bc34a 45%,
        #2e7d32 100%
    );
}

/* ===========================
   GLOBAL JC WATERMARK
=========================== */



body::after{

    content:"";

    position:absolute;

    inset:0;

    background:

    radial-gradient(circle at 15% 25%, rgba(255,255,255,.12), transparent 180px),

    radial-gradient(circle at 80% 20%, rgba(255,255,255,.08), transparent 220px),

    radial-gradient(circle at 60% 80%, rgba(255,255,255,.10), transparent 250px),

    radial-gradient(circle at 35% 60%, rgba(255,255,255,.08), transparent 200px);

    pointer-events:none;

    z-index:0;

}

.container{

    width:1000px;
    max-width:84%;

    height:750px;

    display:flex;

    background:white;

    border-radius:28px;

    overflow:hidden;

    position:relative;

    z-index:2;

    box-shadow:

    0 35px 80px rgba(0,0,0,.18);

}


.register-card{

    border:none;

    border-radius:25px;

    overflow:hidden;

    background:rgba(255,255,255,.96);

    backdrop-filter:blur(12px);

}

.left-side{

    flex:1;

    position:relative;

    overflow:hidden;

    color:white;

    padding:70px 55px;

    display:flex;

    flex-direction:column;

    justify-content:center;

    background:

    radial-gradient(circle at top left,
    rgba(255,255,255,.22),
    transparent 220px),

    radial-gradient(circle at bottom right,
    rgba(255,255,255,.12),
    transparent 280px),

    linear-gradient(
        180deg,
        #6b9415ff 0%,
        #6DBB38 38%,
        #2E7D32 100%
    );

}
.left-side h2{

    font-size:38px;

    font-weight:800;

    line-height:1.2;

    margin-top:20px;

    text-shadow:
    0 3px 12px rgba(0,0,0,.25);

}

.left-side p{

    margin-top:18px;

    font-size:16px;

    line-height:30px;

    color:rgba(255,255,255,.92);

}

.right-side{

    padding:55px;

    background:

    linear-gradient(

    180deg,

    white,

    #fbfff6

    );

}

.form-control{

    height:56px;

    border-radius:14px;

    border:2px solid #dfead4;

    background:#fbfff8;

    transition:.3s;

    font-size:15px;

}

.form-control:focus{

    border-color:#8BC34A;

    box-shadow:

    0 0 0 5px rgba(139,195,74,.15);

    background:white;

}

/* ===========================
   PREMIUM CREATE ACCOUNT BUTTON
=========================== */

.btn-success{

    height:58px;

    border:none;

    border-radius:16px;

    font-size:17px;

    font-weight:700;

    letter-spacing:.5px;

    color:#294400;

    background:linear-gradient(
        90deg,
        #FFF8A6 0%,
        #D7F16C 35%,
        #A9D82F 70%,
        #82B81E 100%
    );

    background-size:200% auto;

    box-shadow:
        0 15px 30px rgba(120,170,25,.35);

    transition:
        .35s ease;

}

.btn-success:hover{

    transform:translateY(-5px);

    background-position:right center;

    box-shadow:
        0 22px 45px rgba(0,0,0,.22);

    color:#173400;

}

.btn-success:active{

    transform:scale(.98);

}

.btn-success i{

    margin-right:8px;

}

.feature{

    display:flex;

    align-items:center;

    gap:12px;

    margin:18px 0;

    font-size:17px;

    font-weight:500;

}



/* ============================= */
/* LEAVES */
/* ============================= */



/* PREMIUM RANDOM WATERMARKS */
.watermarks{position:fixed;inset:0;pointer-events:none;z-index:1;overflow:hidden;}
.watermarks img{position:absolute;filter:grayscale(100%);}
.watermarks img:nth-child(1){width:100px;left:84%;bottom:10%;opacity:50;transform:rotate(38deg);}
.watermarks img:nth-child(2){width:79px;right:90%;top:12%;opacity:40;transform:rotate(39deg);}
.watermarks img:nth-child(3){width:77px;left:90%;top:27%;opacity:30;transform:rotate(41deg);}
.watermarks img:nth-child(4){width:125px;right:90%;top:8%;opacity:20;transform:rotate(15deg);}
.watermarks img:nth-child(5){width:140px;left:90%;top:7%;opacity:10;transform:rotate(27deg);}
.watermarks img:nth-child(6){width:98px;left:80%;top:80%;opacity:50;transform:rotate(29deg);}
.watermarks img:nth-child(7){width:143px;right:90%;top:50%;opacity:30;transform:rotate(39deg);}
.watermarks img:nth-child(8){width:75px;left:90%;top:17%;opacity:40;transform:rotate(8deg);}
.watermarks img:nth-child(9){width:88px;right:90%;top:15%;opacity:30;transform:rotate(28deg);}
.watermarks img:nth-child(10){width:141px;right:90%;bottom:23%;opacity:20;transform:rotate(32deg);}
.watermarks img:nth-child(13){width:96px;right:90%;bottom:87%;opacity:20;transform:rotate(23deg);}eg);}
.watermarks img:nth-child(17){width:137px;left:90%%;bottom:43%;opacity:30;transform:rotate(12deg);}
.watermarks img:nth-child(18){width:147px;left;90%top:15%;opacity:35;transform:rotate(20deg);}
.watermarks img:nth-child(19){width:91px;left:90%;bottom:19%;opacity:35;transform:rotate(17deg);}
.watermarks img:nth-child(20){width:75px;left:90%;top:9%;opacity:40;transform:rotate(26deg);}


</style>

</head>

<body>

<div class="leaf leaf-top-left"></div>
<div class="leaf leaf-top-right"></div>
<div class="leaf leaf-bottom-left"></div>
<div class="leaf leaf-bottom-right"></div>

<div class="watermarks">
    <img src="assets/images/logo.png" alt="">
    <img src="assets/images/logo.png" alt="">
    <img src="assets/images/logo.png" alt="">
    <img src="assets/images/logo.png" alt="">
    <img src="assets/images/logo.png" alt="">
    <img src="assets/images/logo.png" alt="">
    <img src="assets/images/logo.png" alt="">
    <img src="assets/images/logo.png" alt="">
    <img src="assets/images/logo.png" alt="">
    <img src="assets/images/logo.png" alt="">
    <img src="assets/images/logo.png" alt="">
    <img src="assets/images/logo.png" alt="">
    <img src="assets/images/logo.png" alt="">
    <img src="assets/images/logo.png" alt="">
    <img src="assets/images/logo.png" alt="">
    
   
    
</div>

<div class="container">

<!-- LEFT -->

<div class="col-lg-5 d-none d-lg-block">

<div class="left-side">

<div class="text-center mb-4">

    <img
    src="assets/images/logo.png"
    alt="JC Barley Logo"
    style="
        width:180px;
        filter:
        drop-shadow(0 10px 30px rgba(0,0,0,.30));
        position:relative;
        z-index:2;
    ">

    <h2 class="mt-3">

        Barley Business

    </h2>

</div>

<p class="mt-3">

Create your own professional portfolio website and manage your achievements, gallery, and customer inquiries.

</p>

<hr>

<div class="feature">

<i class="bi bi-trophy-fill"></i>

Achievements Management

</div>

<div class="feature">

<i class="bi bi-images"></i>

Gallery Management

</div>

<div class="feature">

<i class="bi bi-envelope-fill"></i>

Customer Messages

</div>

<div class="feature">

<i class="bi bi-globe"></i>

Personal Website

</div>

</div>

</div>

<!-- RIGHT -->

<div class="col-lg-7">

<div class="right-side">

<h3 class="fw-bold mb-4">

Create Account

</h3>

<form
action="auth/register.php"
method="POST">

<div class="mb-3">

<label class="form-label">

Full Name

</label>

<input
type="text"
name="fullname"
class="form-control"
required>

</div>

<div class="mb-3">

<label class="form-label">

Username

</label>

<input
type="text"
name="username"
class="form-control"
required>

</div>

<div class="mb-3">

<label class="form-label">

Email Address

</label>

<input
type="email"
name="email"
class="form-control"
required>

</div>

<div class="row">

<div class="col-md-6 mb-3">

<label class="form-label">

Password

</label>

<input
type="password"
name="password"
class="form-control"
required>

</div>

<div class="col-md-6 mb-3">

<label class="form-label">

Confirm Password

</label>

<input
type="password"
name="confirm_password"
class="form-control"
required>

</div>

</div>

<div class="d-grid mt-3">

<button
class="btn btn-success"
type="submit">

<i class="bi bi-person-plus-fill"></i>

Create Account

</button>

</div>

<div class="text-center mt-4">

Already have an account?

<a
href="login.php"
class="text-success text-decoration-none fw-bold">

Login

</a>

</div>

</form>

</div>

</div>

</div>

</div>

</div>

</div>

</div>

</body>

</html>