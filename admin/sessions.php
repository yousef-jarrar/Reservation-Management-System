<?php
session_start();

if (!isset($_SESSION["user_id"]) || $_SESSION["role"] != "admin") {
    header("Location: ../login.php");
    exit;
}

require_once __DIR__ . "/../classes/TherapySession.php";

$therapySession = new TherapySession();
$message = "";

if (isset($_GET["success"])) {
    $message = "Session added successfully!";
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST["name"] ?? "");
    $duration = (int) ($_POST["duration"] ?? 0);
    $price = (float) ($_POST["price"] ?? 0);

    if ($name != "" && $duration > 0 && $price >= 0) {
        $therapySession->addSession($name, $duration, $price);

        header("Location: sessions.php?success=1");
        exit;
    } else {
        $message = "Please enter valid session information.";
    }
}

$sessions = $therapySession->getAllSessions();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Sessions</title>
    <link rel="stylesheet" href="../css/style.css?v=3">
</head>
<body>

<div class="dashboard-layout">

    <?php include __DIR__ . "/sidebar.php"; ?>

    <main class="dashboard-main">

        <div class="dashboard-header">
            <h1>Manage Sessions</h1>
            <p>Add, edit, and manage therapy sessions.</p>
        </div>

        <div class="management-card">
            <h2>Add New Session</h2>

            <form method="POST" class="management-form">
                <label>Session Name</label>
                <input type="text" name="name" placeholder="Enter session name" required>

                <label>Duration (minutes)</label>
                <input type="number" name="duration" min="1" placeholder="Enter duration" required>

                <label>Price (JOD)</label>
                <input type="number" name="price" min="0" step="0.01" placeholder="Enter price" required>

                <button type="submit" class="btn-primary">Add Session</button>
            </form>

            <?php if ($message != ""): ?>
                <p class="form-message"><?= htmlspecialchars($message) ?></p>
            <?php endif; ?>
        </div>

        <div class="management-card">
            <h2>All Sessions</h2>

            <div class="table-container">
                <table class="management-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Session Name</th>
                            <th>Duration</th>
                            <th>Price (JOD)</th>
                            <th>Actions</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php foreach ($sessions as $session): ?>
                            <tr>
                                <td><?= (int) $session["id"] ?></td>
                                <td><?= htmlspecialchars($session["name"]) ?></td>
                                <td><?= (int) $session["duration"] ?> min</td>
                                <td><?= htmlspecialchars($session["price"]) ?></td>
                                <td>
                                    <div class="table-actions">
                                        <a class="btn-edit" href="edit-session.php?id=<?= (int) $session["id"] ?>">
                                            Edit
                                        </a>

                                        <form action="delete-session.php" method="POST"
                                              onsubmit="return confirm('Are you sure you want to delete this session?');">
                                            <input type="hidden" name="id" value="<?= (int) $session["id"] ?>">
                                            <button type="submit" class="btn-delete">Delete</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>

    </main>
</div>

</body>
</html>