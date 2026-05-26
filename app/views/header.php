<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Password Manager</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >
    <link
    rel="stylesheet"
    href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"
>

</head>

<body class="bg-light">

<nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow">

    <div class="container">

        <a class="navbar-brand fw-bold" href="dashboard.php">

            <i class="bi bi-shield-lock-fill"></i>

            Password Manager

        </a>

        <?php if (isset($_SESSION['user_id'])): ?>

            <div class="d-flex align-items-center">

                <span class="text-white me-3">

                    <i class="bi bi-person-circle"></i>

                    <?php echo $_SESSION['username']; ?>

                </span>

                <a
                    href="logout.php"
                    class="btn btn-danger btn-sm"
                >
                    <i class="bi bi-box-arrow-right"></i>

                    Logout
                </a>

            </div>

        <?php endif; ?>

    </div>

</nav>

<div class="container mt-5">