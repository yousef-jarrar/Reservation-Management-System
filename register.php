<?php
require_once __DIR__ . "/classes/User.php";

$message = "";
$success = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $name = trim($_POST["name"]);
    $email = trim($_POST["email"]);
    $password = $_POST["password"];

    if ($name != "" && filter_var($email, FILTER_VALIDATE_EMAIL) && $password != "") {

        $user = new User();

        try {

            $user->register($name, $email, $password);

            $message = "Registration successful! You can now login.";
            $success = true;

        } catch (PDOException $e) {

            $message = "Registration failed. Email may already exist.";

        }

    } else {

        $message = "Please enter valid information.";

    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Register - PhysioCare</title>

    <link rel="stylesheet" href="css/style.css">
</head>

<body class="auth-page">

    <div class="auth-card">

        <div class="auth-header">
            <h1>PhysioCare</h1>
            <p>Create your account to get started.</p>
        </div>

        <h2>Create Account</h2>

        <form method="POST">

            <label>Full Name</label>

            <input
                type="text"
                name="name"
                placeholder="Enter your full name"
                required
            >

            <label>Email Address</label>

            <input
                type="email"
                name="email"
                placeholder="Enter your email"
                required
            >

            <label>Password</label>

            <input
                type="password"
                name="password"
                placeholder="Create a password"
                required
            >

            <button type="submit" class="btn-primary">
                Register
            </button>

        </form>

        <?php if ($message != ""): ?>

            <p class="<?= $success ? 'success-message' : 'error-message' ?>">
                <?= htmlspecialchars($message) ?>
            </p>

        <?php endif; ?>

        <?php if ($success): ?>

            <p class="auth-footer">
                <a href="login.php">Continue to Login →</a>
            </p>

        <?php else: ?>

            <p class="auth-footer">
                Already have an account?
                <a href="login.php">Login</a>
            </p>

        <?php endif; ?>

        <p class="auth-footer">
            <a href="index.php">← Back to Home</a>
        </p>

    </div>

</body>
</html>