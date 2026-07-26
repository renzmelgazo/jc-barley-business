<!DOCTYPE html>
<html lang="en">


<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Create Account | JC Barley Website</title>

<link
href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
rel="stylesheet">

<link
rel="stylesheet"
href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

<link rel="stylesheet" href="css/auth.css">

</head>
<style>

    .container{
    padding:0;
}

.row{
    margin:0;
}

.col-lg-5,
.col-lg-7{
    padding:0;
}

    

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
        #8dcb4eff 0%,
        rgba(139, 195, 74, 1) 45%,
        #2e7d32 100%
    );
}

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

    background:rgba(255, 255, 255, 0.96);

    backdrop-filter:blur(12px);

}

.left-side{

    flex:1;

    position:relative;

    overflow:hidden;

    color:white;

    padding:72px 55px;

    display:flex;

    border-radius:28px 0 0 28px;

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

    background:white;

    border-radius:0 28px 28px 0;

    padding:55px;

    background:linear-gradient(180deg,white,#fbfff6);

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

    background-size:% auto;

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

    margin:10px 0;

    font-size:17px;

    font-weight:500;

}



/* ============================= */
/* LEAVES */
/* ============================= */


/* =====================================
   JC LOGO WATERMARK BACKGROUND
===================================== */

.watermarks{

    position:fixed;

    inset:0;

    overflow:hidden;

    pointer-events:none;

    z-index:1;

}

.watermarks img{

    position:absolute;

    width:120px;

    opacity:.65;

    filter:grayscale(100%);

    transition:.3s;

}


.watermarks img:nth-child(1){bottom:93%;right:17%;width:110px;}
.watermarks img:nth-child(2){bottom:88%;right:27%;}
.watermarks img:nth-child(3){bottom:93%;right:37%;}
.watermarks img:nth-child(4){bottom:95%;right:47%;}
.watermarks img:nth-child(5){bottom:88%;right:57%;}
.watermarks img:nth-child(6){bottom:94%;right:65%;}


.watermarks img:nth-child(7){bottom:94%;right:94%;}
.watermarks img:nth-child(8){bottom:92%;right:75%;}
.watermarks img:nth-child(9){bottom:84%;right:45%;}
.watermarks img:nth-child(10){bottom:90%;right:85%;}
.watermarks img:nth-child(11){bottom:80%;right:93%;}


.watermarks img:nth-child(12){bottom:70%;right:84%;}
.watermarks img:nth-child(13){bottom:60%;right:93%;}
.watermarks img:nth-child(14){bottom:50%;right:83%;}
.watermarks img:nth-child(15){bottom:40%;right:91%;}
.watermarks img:nth-child(16){bottom:30%;right:85%;}


.watermarks img:nth-child(17){bottom:20%;right:93%;}
.watermarks img:nth-child(18){bottom:10%;right:83%;}
.watermarks img:nth-child(19){bottom:0%;right:90%;}
.watermarks img:nth-child(20){bottom:-5%;right:79%;}
.watermarks img:nth-child(21){bottom:-2%;right:65%;}


.watermarks img:nth-child(22){bottom:-10%;right:57%;}
.watermarks img:nth-child(23){bottom:-9%;right:37%;}
.watermarks img:nth-child(24){bottom:-3%;right:47%;}
.watermarks img:nth-child(25){bottom:-15%;right:17%;}
.watermarks img:nth-child(26){bottom:-2%;right:27%;}


.watermarks img:nth-child(27){top:70%;left:84%;}
.watermarks img:nth-child(28){top:60%;left:93%;}
.watermarks img:nth-child(29){top:50%;left:83%;}
.watermarks img:nth-child(30){top:40%;left:91%;}
.watermarks img:nth-child(31){top:30%;left:85%;}

.watermarks img:nth-child(32){top:20%;left:93%;}
.watermarks img:nth-child(33){top:10%;left:83%;}
.watermarks img:nth-child(34){top:0%;left:90%;}

.watermarks img:nth-child(35){top:94%;left:94%;}
.watermarks img:nth-child(36){top:92%;left:75%;}
.watermarks img:nth-child(37){top:96%;left:89%;}
.watermarks img:nth-child(38){top:90%;left:85%;}
.watermarks img:nth-child(39){top:80%;left:93%;}
</style>

</head>

<body>



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

<div class="row m-0">

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