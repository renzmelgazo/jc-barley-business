<?php
include 'includes/header.php';

if (isset($_GET['success'])) {
?>

<div class="container mt-4">

    <div class="alert alert-success">

        Your message has been sent successfully!

    </div>

</div>

<?php
}
?>

<div class="container py-5">

    <div class="row justify-content-center">

        <div class="col-lg-8">

            <div class="card shadow">

                <div class="card-header bg-success text-white">

                    <h3 class="mb-0">Contact Us</h3>

                </div>

                <div class="card-body">

                    <form
                        action="auth/save_contact.php"
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
                                Email Address
                            </label>

                            <input
                                type="email"
                                name="email"
                                class="form-control"
                                required>

                        </div>

                        <div class="mb-3">

                            <label class="form-label">
                                Subject
                            </label>

                            <input
                                type="text"
                                name="subject"
                                class="form-control"
                                required>

                        </div>

                        <div class="mb-3">

                            <label class="form-label">
                                Message
                            </label>

                            <textarea
                                name="message"
                                rows="6"
                                class="form-control"
                                required></textarea>

                        </div>

                        <button
                            type="submit"
                            class="btn btn-success">

                            Send Message

                        </button>

                    </form>

                </div>

            </div>

        </div>

    </div>

</div>

<?php
include 'includes/footer.php';
?>