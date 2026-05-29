<?php

session_start();

if (!isset($_SESSION['user_id'])) {

    header("Location: login.php");

    exit();
}

require_once '../app/classes/User.php';

$message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $currentPassword =
        trim($_POST['current_password']);

    $newPassword =
        trim($_POST['new_password']);

    if (
        !empty($currentPassword)
        &&
        !empty($newPassword)
    ) {

        $user = new User();

        $message = $user->changePassword(
            $_SESSION['user_id'],
            $currentPassword,
            $newPassword
        );

    } else {

        $message = "All fields are required";
    }
}

include '../app/views/header.php';
?>

<div class="row justify-content-center">

    <div class="col-md-6">

        <div class="card shadow">

            <div class="card-body">

                <h2 class="mb-4">
                    Change Password
                </h2>

                <?php if ($message): ?>

                    <div class="alert alert-info">
                        <?php echo $message; ?>
                    </div>

                <?php endif; ?>

                <form method="POST">

                    <div class="mb-3">

                        <label class="form-label">
                            Current Password
                        </label>

                        <input
                            type="password"
                            name="current_password"
                            class="form-control"
                            required
                        >

                    </div>

                    <div class="mb-3">

                        <label class="form-label">
                            New Password
                        </label>

                        <input
                            type="password"
                            name="new_password"
                            class="form-control"
                            required
                        >

                    </div>

                    <button
                        type="submit"
                        class="btn btn-warning w-100"
                    >
                        Change Password
                    </button>

                </form>

            </div>

        </div>

    </div>

</div>

<?php include '../app/views/footer.php'; ?>