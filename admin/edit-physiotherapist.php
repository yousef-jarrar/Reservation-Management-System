<?php
session_start();

if (!isset($_SESSION["user_id"]) || $_SESSION["role"] != "admin") {
    header("Location: ../login.php");
    exit;
}

require_once __DIR__ . "/../classes/User.php";

$user = new User();

$id = (int) ($_GET["id"] ?? 0);
$physio = $user->getPhysiotherapistById($id);

if (!$physio) {
    exit("Physiotherapist not found.");
}

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST["name"] ?? "");
    $email = trim($_POST["email"] ?? "");
    $password = $_POST["password"] ?? "";

    if ($name != "" && filter_var($email, FILTER_VALIDATE_EMAIL)) {
        try {
            $user->updatePhysiotherapist($id, $name, $email, $password);
            $message = "Physiotherapist updated successfully!";
            $physio = $user->getPhysiotherapistById($id);
        } catch (PDOException $e) {
            $message = "Unable to update. Email may already exist.";
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
    <title>Edit Physiotherapist</title>
    <link rel="stylesheet" href="../css/style.css?v=3">
</head>
<body>

<div class="dashboard-layout">

    <?php include __DIR__ . "/sidebar.php"; ?>

    <main class="dashboard-main">

        <div class="dashboard-header">
            <h1>Edit Physiotherapist</h1>
            <p>Update physiotherapist account information.</p>
        </div>

        <div class="management-card">
            <h2>Physiotherapist Information</h2>

            <form method="POST" class="management-form">
                <label>Full Name</label>
                <input type="text" name="name"
                       value="<?= htmlspecialchars($physio["name"]) ?>" required>

                <label>Email Address</label>
                <input type="email" name="email"
                       value="<?= htmlspecialchars($physio["email"]) ?>" required>

                <label>New Password (Optional)</label>
                <input type="password" name="password"
                       placeholder="Leave empty to keep current password">

                <button type="submit" class="btn-primary">
                    Update Physiotherapist
                </button>
            </form>

            <?php if ($message != ""): ?>
                <p class="form-message"><?= htmlspecialchars($message) ?></p>
            <?php endif; ?>

            <p>
                <a href="physiotherapists.php">← Back to Physiotherapists</a>
            </p>
        </div>

    </main>

</div>

</body>
</html>