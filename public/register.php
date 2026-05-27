<?php

require_once '../app/classes/User.php';

session_start();
//user won't be able to access this page if logged in
if (isset($_SESSION['user_id'])) {
    header("Location: dashboard.php");
    exit;
}

$message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $username = trim($_POST['username']);

    $password = trim($_POST['password']);

    if (!empty($username) && !empty($password)) {

        $user = new User();

        $message = $user->register($username, $password);

    } else {

        $message = "All fields are required";
    }
}

include '../app/views/header.php';
?>

<div class="row justify-content-center">

    <div class="col-md-5">

        <div class="card shadow">

            <div class="card-body">

                <h2 class="text-center mb-4">
                    Register
                </h2>

                <?php if ($message): ?>

                    <div class="alert alert-info">
                        <?php echo $message; ?>
                    </div>

                <?php endif; ?>

                <form method="POST">

                    <div class="mb-3">

                        <label class="form-label">
                            Username
                        </label>

                        <input
                            type="text"
                            name="username"
                            class="form-control"
                            required
                        >

                    </div>

                    <div class="mb-3">

                        <label class="form-label">
                            Password
                        </label>

                        <input
                            type="password"
                            name="password"
                            class="form-control"
                            required
                        >

                    </div>

                    <button
                        type="submit"
                        class="btn btn-dark w-100"
                    >
                        Register
                    </button>

                </form>

                <div class="text-center mt-3">

                    <a href="login.php">
                        Already have an account?
                    </a>

                </div>

            </div>

        </div>

    </div>

</div>

<?php include '../app/views/footer.php'; ?>