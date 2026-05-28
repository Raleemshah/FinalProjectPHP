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

$passwordEntry = new PasswordEntry();

$entries = $passwordEntry->getPasswords(
    $_SESSION['user_id'],
    $_SESSION['plain_password']
);

include '../app/views/header.php';
?>

<div class="card shadow">

    <div class="card-body">

        <h2 class="mb-4">
            Saved Passwords
        </h2>

        <div class="table-responsive">

            <table class="table table-bordered table-hover">

                <thead class="table-dark">

                    <tr>

                        <th>
                            Website / App
                        </th>

                        <th>
                            Password
                        </th>

                        <th>
                            Created At
                        </th>
                        <th>
    Actions
</th>



                    </tr>

                </thead>

                <tbody>

                    <?php foreach ($entries as $entry): ?>

                        <tr>

                            <td>
                                <?php echo htmlspecialchars(
                                    $entry['website_name']
                                ); ?>
                            </td>

                           <td>

    <div class="d-flex align-items-center gap-2">

        <input
            type="password"
            value="<?php echo htmlspecialchars(
                $entry['decrypted_password']
            ); ?>"
            class="form-control password-field"
            readonly
        >

        <button
            class="btn btn-secondary toggle-password"
            type="button"
        >
            <i class="bi bi-eye"></i>
        </button>

        <button
            class="btn btn-primary copy-password"
            type="button"
            data-password="<?php echo htmlspecialchars(
                $entry['decrypted_password']
            ); ?>"
        >
            <i class="bi bi-clipboard"></i>
        </button>

    </div>

</td>

                            <td>
                                <?php echo htmlspecialchars(
                                    $entry['created_at']
                                ); ?>
                            </td>
                            <td>

    <a
        href="delete_password.php?id=<?php
            echo $entry['id'];
        ?>"
        class="btn btn-danger btn-sm"
        onclick="return confirm(
            'Delete this password?'
        )"
    >
        Delete
    </a>

</td>

                        </tr>

                    <?php endforeach; ?>

                </tbody>

            </table>

        </div>

    </div>

</div>

<?php include '../app/views/footer.php'; ?>
<?php include '../app/views/footer.php'; ?>
<script>

document.querySelectorAll('.toggle-password')
.forEach(button => {

    button.addEventListener('click', () => {

        const input =
            button.parentElement.querySelector(
                '.password-field'
            );

        const icon = button.querySelector('i');

        if (input.type === 'password') {

            input.type = 'text';

            icon.classList.remove('bi-eye');

            icon.classList.add('bi-eye-slash');

        } else {

            input.type = 'password';

            icon.classList.remove('bi-eye-slash');

            icon.classList.add('bi-eye');
        }
    });
});

document.querySelectorAll('.copy-password')
.forEach(button => {

    button.addEventListener('click', () => {

        const password =
            button.dataset.password;

        navigator.clipboard.writeText(password);

        button.innerHTML =
            '<i class="bi bi-check-lg"></i>';

        setTimeout(() => {

            button.innerHTML =
                '<i class="bi bi-clipboard"></i>';

        }, 1500);
    });
});

</script>