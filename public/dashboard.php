<?php

session_start();

if (!isset($_SESSION['user_id'])) {

    header("Location: login.php");

    exit();
}

include '../app/views/header.php';
?>

<div class="row">

    <div class="col-md-12">

        <div class="card shadow border-0">

            <div class="card-body">

                <h1 class="mb-5 text-center">

                    Welcome,
                    <?php echo htmlspecialchars(
                        $_SESSION['username']
                    ); ?>

                </h1>

                <div class="row g-4">

                    <!-- Password Vault -->

                    <div class="col-md-6 col-lg-3">

                        <a
                            href="view_passwords.php"
                            class="text-decoration-none"
                        >

                            <div class="card bg-dark text-white shadow border-0 h-100">

                                <div class="card-body text-center py-5">

                                    <h1 class="mb-3">

                                        <i class="bi bi-safe-fill"></i>

                                    </h1>

                                    <h4>
                                        Password Vault
                                    </h4>

                                    <p>
                                        View saved passwords
                                    </p>

                                </div>

                            </div>

                        </a>

                    </div>

                    <!-- Add Password -->

                    <div class="col-md-6 col-lg-3">

                        <a
                            href="add_password.php"
                            class="text-decoration-none"
                        >

                            <div class="card bg-primary text-white shadow border-0 h-100">

                                <div class="card-body text-center py-5">

                                    <h1 class="mb-3">

                                        <i class="bi bi-plus-circle-fill"></i>

                                    </h1>

                                    <h4>
                                        Add Password
                                    </h4>

                                    <p>
                                        Save encrypted credentials
                                    </p>

                                </div>

                            </div>

                        </a>

                    </div>

                    <!-- Generator -->

                    <div class="col-md-6 col-lg-3">

                        <a
                            href="generator.php"
                            class="text-decoration-none"
                        >

                            <div class="card bg-success text-white shadow border-0 h-100">

                                <div class="card-body text-center py-5">

                                    <h1 class="mb-3">

                                        <i class="bi bi-key-fill"></i>

                                    </h1>

                                    <h4>
                                        Generator
                                    </h4>

                                    <p>
                                        Generate secure passwords
                                    </p>

                                </div>

                            </div>

                        </a>

                    </div>

                    <!-- Change Password -->

                    <div class="col-md-6 col-lg-3">

                        <a
                            href="change_password.php"
                            class="text-decoration-none"
                        >

                            <div class="card bg-warning text-dark shadow border-0 h-100">

                                <div class="card-body text-center py-5">

                                    <h1 class="mb-3">

                                        <i class="bi bi-arrow-repeat"></i>

                                    </h1>

                                    <h4>
                                        Change Password
                                    </h4>

                                    <p>
                                        Update login credentials
                                    </p>

                                </div>

                            </div>

                        </a>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

<?php include '../app/views/footer.php'; ?>


