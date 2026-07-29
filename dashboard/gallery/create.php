<form
    action="../../auth/save_gallery.php"
    method="POST"
    enctype="multipart/form-data">

    <div class="mb-3">

        <label class="form-label">
            Title
        </label>

        <input
            type="text"
            name="title"
            class="form-control"
            required>

    </div>

    <div class="mb-3">

        <label class="form-label">
            Description
        </label>

        <div class="mb-3">

    <label class="form-label">

        Website Section

    </label>

    <select
        name="section"
        class="form-select"
        required>

        <option value="">Select Section</option>

        <option value="hero">Hero Banner</option>

        <option value="about">About Section</option>

        <option value="gallery">Gallery Section</option>

        <option value="achievement">Achievement Section</option>

        <option value="testimonial">Testimonials</option>

    </select>

</div>

        <textarea
            name="description"
            class="form-control"
            rows="4"></textarea>

    </div>

    <div class="mb-3">

        <label class="form-label">
            Website Section
        </label>

        <select
            name="section"
            class="form-select"
            required>

            <option value="">Select Section</option>

            <option value="hero">
                Hero Banner
            </option>

            <option value="about">
                About Section
            </option>

            <option value="gallery">
                Gallery
            </option>

            <option value="testimonial">
                Testimonials
            </option>

            <option value="achievement">
                Achievement
            </option>

        </select>

    </div>

    <div class="mb-3">

        <label class="form-label">
            Image
        </label>

        <input
            type="file"
            name="image"
            class="form-control"
            accept=".jpg,.jpeg,.png,.webp"
            required>

    </div>

    <button
        type="submit"
        class="btn btn-success">

        Save Gallery

    </button>

    <a
        href="index.php"
        class="btn btn-secondary">

        Cancel

    </a>

</form>