<?php
session_start();

require_once __DIR__ . "/classes/User.php";

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $email = trim($_POST["email"]);
    $password = $_POST["password"];

    $user = new User();
    $result = $user->login($email, $password);

    if ($result) {

        session_regenerate_id(true);

        $_SESSION["user_id"] = $result["id"];
        $_SESSION["name"] = $result["name"];
        $_SESSION["role"] = $result["role"];

        // Redirect all users to Home
        header("Location: index.php");
        exit;

    } else {
        $message = "Invalid email or password";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Login - PhysioCare</title>

    <link rel="stylesheet" href="css/style.css">
</head>

<body class="auth-page">

    <div class="auth-card">

        <div class="auth-header">
            <h1>PhysioCare</h1>
            <p>Welcome back! Sign in to your account.</p>
        </div>

        <h2>Login</h2>

        <form method="POST">

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
                placeholder="Enter your password"
                required
            >

            <button type="submit" class="btn-primary">
                Login
            </button>

        </form>

        <?php if ($message != ""): ?>

            <p class="error-message">
                <?= htmlspecialchars($message) ?>
            </p>

        <?php endif; ?>

        <p class="auth-footer">
            Don't have an account?
            <a href="register.php">Register</a>
        </p>

        <p class="auth-footer">
            <a href="index.php">← Back to Home</a>
        </p>

    </div>

</body>
</html>