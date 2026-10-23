<?php
session_start();

if (!isset($_SESSION["user_id"]) || $_SESSION["role"] != "admin") {
    header("Location: ../login.php");
    exit;
}

require_once __DIR__ . "/../classes/TherapySession.php";

$therapySession = new TherapySession();

$id = (int) ($_GET["id"] ?? 0);
$session = $therapySession->getSessionById($id);

if (!$session) {
    exit("Session not found.");
}

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST["name"] ?? "");
    $duration = (int) ($_POST["duration"] ?? 0);
    $price = (float) ($_POST["price"] ?? -1);

    if ($name != "" && $duration > 0 && $price >= 0) {
        $therapySession->updateSession($id, $name, $duration, $price);

        header("Location: edit-session.php?id=$id&success=1");
        exit;
    } else {
        $message = "Please enter valid information.";
    }
}

if (isset($_GET["success"])) {
    $message = "Session updated successfully!";
}

$session = $therapySession->getSessionById($id);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Session</title>
    <link rel="stylesheet" href="../css/style.css?v=3">
</head>
<body>

<div class="dashboard-layout">

    <?php include __DIR__ . "/sidebar.php"; ?>

    <main class="dashboard-main">

        <div class="dashboard-header">
            <h1>Edit Session</h1>
            <p>Update therapy session information.</p>
        </div>

        <div class="management-card">
            <h2>Session Information</h2>

            <form method="POST" class="management-form">
                <label>Session Name</label>
                <input type="text" name="name"
                       value="<?= htmlspecialchars($session["name"]) ?>" required>

                <label>Duration (minutes)</label>
                <input type="number" name="duration" min="1"
                       value="<?= (int) $session["duration"] ?>" required>

                <label>Price (JOD)</label>
                <input type="number" name="price" min="0" step="0.01"
                       value="<?= htmlspecialchars($session["price"]) ?>" required>

                <button type="submit" class="btn-primary">
                    Update Session
                </button>
            </form>

            <?php if ($message != ""): ?>
                <p class="form-message"><?= htmlspecialchars($message) ?></p>
            <?php endif; ?>

            <p>
                <a href="sessions.php">← Back to Sessions</a>
            </p>
        </div>

    </main>

</div>

</body>
</html>