<?php

session_start();

//unauthenticated users should not be able to access this page


if (!isset($_SESSION['user_id'])) {

    header("Location: login.php");

    exit();
}

require_once '../app/classes/PasswordGenerator.php';

$generatedPassword = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $length = (int) $_POST['length'];

    $uppercase = (int) $_POST['uppercase'];

    $lowercase = (int) $_POST['lowercase'];

    $numbers = (int) $_POST['numbers'];

    $special = (int) $_POST['special'];

    $total =
        $uppercase +
        $lowercase +
        $numbers +
        $special;

    if ($total != $length) {

        $generatedPassword =
            "Character counts must equal total length.";

    } else {

        $generator = new PasswordGenerator();

        $generatedPassword = $generator->generate(
            $length,
            $uppercase,
            $lowercase,
            $numbers,
            $special
        );
    }
}

include '../app/views/header.php';
?>

<div class="row justify-content-center">

    <div class="col-md-6">

        <div class="card shadow">

            <div class="card-body">

                <h2 class="mb-4">
                    Password Generator
                </h2>

                <form method="POST">

                    <div class="mb-3">

                        <label class="form-label">
                            Total Length
                        </label>

                        <input
                            type="number"
                            name="length"
                            class="form-control"
                            required
                        >

                    </div>

                    <div class="mb-3">

                        <label class="form-label">
                            Uppercase Letters
                        </label>

                        <input
                            type="number"
                            name="uppercase"
                            class="form-control"
                            required
                        >

                    </div>

                    <div class="mb-3">

                        <label class="form-label">
                            Lowercase Letters
                        </label>

                        <input
                            type="number"
                            name="lowercase"
                            class="form-control"
                            required
                        >

                    </div>

                    <div class="mb-3">

                        <label class="form-label">
                            Numbers
                        </label>

                        <input
                            type="number"
                            name="numbers"
                            class="form-control"
                            required
                        >

                    </div>

                    <div class="mb-3">

                        <label class="form-label">
                            Special Characters
                        </label>

                        <input
                            type="number"
                            name="special"
                            class="form-control"
                            required
                        >

                    </div>

                    <button
                        type="submit"
                        class="btn btn-success w-100"
                    >
                        Generate Password
                    </button>

                </form>

                <?php if ($generatedPassword): ?>

                    <div class="alert alert-dark mt-4">

                        <strong>
                            Generated Password:
                        </strong>

                        <br><br>

                        <span class="fs-4">
                            <?php echo htmlspecialchars(
                                $generatedPassword
                            ); ?>
                        </span>

                    </div>

                <?php endif; ?>

            </div>

        </div>

    </div>

</div>

<?php include '../app/views/footer.php'; ?>