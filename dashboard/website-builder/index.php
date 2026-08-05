    <?php

    require '../../config/session.php';
    require '../../config/database.php';

    if(!isset($_SESSION['user_id'])){
        header("Location: ../../login.php");
        exit;
    }

    $stmt = $conn->prepare("
    SELECT *
    FROM website_settings
    WHERE owner_id = :owner
    LIMIT 1
    ");

    $stmt->execute([
        ':owner' => $_SESSION['user_id']
    ]);

    $website = $stmt->fetch(PDO::FETCH_ASSOC);

    include '../../includes/header.php';
    include '../../includes/sidebar.php';
    include '../../includes/navbar.php';

    ?>

    <div class="main-content">

    <div class="content">

    <div class="container-fluid">

    <h2 class="mb-4 fw-bold">

    🌐 Website Builder

    </h2>

    <form
    action="../../auth/save_website_builder.php"
    method="POST"
    enctype="multipart/form-data">

    <!-- HERO -->

    <div class="card shadow mb-4">

    <div class="card-header bg-success text-white">

    <h4 class="mb-0">

    Hero Section

    </h4>

    </div>

    <div class="card-body">

    <div class="row">

    <div class="col-md-6">

    <div class="mb-3">

        <label>Website Name</label>

        <input
            type="text"
            name="website_name"
            class="form-control"
            value="<?= htmlspecialchars($website['website_name'] ?? '') ?>">

    </div>

    <label>Hero Image</label>

    <input
    type="file"
    name="hero_image"
    class="form-control">

    <?php if(!empty($website['hero_image'])): ?>

    <img
    src="../../uploads/website/<?= $website['hero_image']; ?>"
    class="img-fluid mt-3 rounded">

    <?php endif; ?>

    </div>

    <div class="col-md-6">

    <label>Hero Title</label>

    <input
    type="text"
    name="hero_title"
    class="form-control"
    value="<?= htmlspecialchars($website['hero_title'] ?? '') ?>">

    <br>

    <label>Hero Description</label>

    <textarea
    name="hero_description"
    class="form-control"
    rows="5"><?= htmlspecialchars($website['hero_description'] ?? '') ?></textarea>

    <br>

    <label>Button Text</label>

    <input
    type="text"
    name="hero_button_text"
    class="form-control"
    value="<?= htmlspecialchars($website['hero_button_text'] ?? '') ?>">

    <br>

    <label>Button Link</label>

    <input
    type="text"
    name="hero_button_link"
    class="form-control"
    value="<?= htmlspecialchars($website['hero_button_link'] ?? '') ?>">

    <br>

    <label>Text Color</label>

    <input
    type="color"
    name="hero_text_color"
    class="form-control form-control-color"
    value="<?= $website['hero_text_color'] ?? '#ffffff'; ?>">

    </div>

    </div>

    </div>

    </div>

    <!-- ABOUT -->

    <div class="card shadow">

    <div class="card-header bg-primary text-white">

    <h4 class="mb-0">

    <!-- STATISTICS -->

    <div class="card shadow mt-4">

    <div class="card-header bg-warning text-dark">

    <h4 class="mb-0">
    📊 Statistics
    </h4>

    </div>

    <!-- TESTIMONIALS -->

    <div class="card shadow mt-4">

    <div class="card-header bg-info text-white">

    <h4 class="mb-0">
    Testimonials
    </h4>

    </div>

    <div class="card-body">

    <p class="text-muted">

    Mamaya natin ito gagawing dynamic gamit ang sariling database table.

    </p>

    </div>

    </div>

    <div class="card-body">

    <div class="row">

    <div class="col-md-3">

    <label>Years in Business</label>

    <input
    type="text"
    name="stat_years"
    class="form-control"
    value="<?= htmlspecialchars($website['stat_years'] ?? '10+') ?>">

    </div>

    <div class="col-md-3">

    <label>Happy Members</label>

    <input
    type="text"
    name="stat_members"
    class="form-control"
    value="<?= htmlspecialchars($website['stat_members'] ?? '5000+') ?>">

    </div>

    <div class="col-md-3">

    <label>Awards</label>

    <input
    type="text"
    name="stat_awards"
    class="form-control"
    value="<?= htmlspecialchars($website['stat_awards'] ?? '100+') ?>">

    </div>

    <div class="col-md-3">

    <label>Success Stories</label>

    <input
    type="text"
    name="stat_success"
    class="form-control"
    value="<?= htmlspecialchars($website['stat_success'] ?? '1000+') ?>">

    </div>

    </div>

    </div>

    </div>

    About Section

    </h4>

    </div>

    <div class="card-body">

    <div class="row">

    <div class="col-md-6">

    <label>About Image</label>

    <input
    type="file"
    name="about_image"
    class="form-control">

    <?php if(!empty($website['about_image'])): ?>

    <img
    src="../../uploads/website/<?= $website['about_image']; ?>"
    class="img-fluid mt-3 rounded">

    <?php endif; ?>

    </div>

    <div class="col-md-6">

    <label>About Title</label>

    <input
    type="text"
    name="about_title"
    class="form-control"
    value="<?= htmlspecialchars($website['about_title'] ?? '') ?>">

    <br>

    <label>About Description</label>

    <textarea
    name="about_description"
    class="form-control"
    rows="5"><?= htmlspecialchars($website['about_description'] ?? '') ?></textarea>

    <br>

    <label>Text Color</label>

    <input
    type="color"
    name="about_text_color"
    class="form-control form-control-color"
    value="<?= $website['about_text_color'] ?? '#000000'; ?>">

    </div>

    </div>

    </div>

    </div>

    <div class="mt-4">

    <button
    class="btn btn-success btn-lg">

    💾 Save Website

    </button>

    </div>

    </form>

    </div>

    </div>

    </div>

    <?php include '../../includes/footer.php'; ?>