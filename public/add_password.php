<?php

session_start();

if (!isset($_SESSION['user_id'])) {

    header("Location: login.php");

    exit();
}

if (!isset($_SESSION['plain_password'])) {

    header("Location: login.php");

    exit();
}

require_once '../app/classes/PasswordEntry.php';

$message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $websiteName = trim($_POST['website_name']);

    $password = trim($_POST['password']);

    if (!empty($websiteName) && !empty($password)) {

        $passwordEntry = new PasswordEntry();

        $saved = $passwordEntry->savePassword(
            $_SESSION['user_id'],
            $websiteName,
            $password,
            $_SESSION['plain_password']
        );

        if ($saved) {

            $message = "Password saved successfully";

        } else {

            $message = "Failed to save password";
        }
    }
}

include '../app/views/header.php';
?>

<div class="row justify-content-center">

    <div class="col-md-6">

        <div class="card shadow">

            <div class="card-body">

                <h2 class="mb-4">
                    Add Password
                </h2>

                <?php if ($message): ?>

                    <div class="alert alert-info">
                        <?php echo $message; ?>
                    </div>

                <?php endif; ?>

                <form method="POST">

                    <div class="mb-3">

                        <label class="form-label">
                            Website / App Name
                        </label>

                        <input
                            type="text"
                            name="website_name"
                            class="form-control"
                            required
                        >

                    </div>

                    <div class="mb-3">

                        <label class="form-label">
                            Password
                        </label>

                        <input
                            type="text"
                            name="password"
                            class="form-control"
                            required
                        >

                    </div>

                    <button
                        type="submit"
                        class="btn btn-dark w-100"
                    >
                        Save Password
                    </button>

                </form>

            </div>

        </div>

    </div>

</div>

<?php include '../app/views/footer.php'; ?>