<?php
session_start();

if (!isset($_SESSION["user_id"]) || $_SESSION["role"] != "admin") {
    header("Location: ../login.php");
    exit;
}

require_once __DIR__ . "/../classes/User.php";

$user = new User();

$message = "";

if (isset($_GET["success"])) {
    $message = "Physiotherapist added successfully!";
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $name = trim($_POST["name"] ?? "");
    $email = trim($_POST["email"] ?? "");
    $password = $_POST["password"] ?? "";

    if ($name != "" && filter_var($email, FILTER_VALIDATE_EMAIL) && $password != "") {

        try {

            $user->addPhysiotherapist($name, $email, $password);

            header("Location: physiotherapists.php?success=1");
            exit;

        } catch (PDOException $e) {

            $message = "Unable to add physiotherapist. Email may already exist.";
        }

    } else {

        $message = "Please enter valid information.";
    }
}

$physiotherapists = $user->getPhysiotherapists();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Manage Physiotherapists</title>

    <link rel="stylesheet" href="../css/style.css?v=2">
</head>

<body>

<div class="dashboard-layout">

    <!-- Shared Sidebar -->
    <?php include __DIR__ . "/sidebar.php"; ?>

    <!-- Main Content -->
    <main class="dashboard-main">

        <div class="dashboard-header">
            <h1>Manage Physiotherapists</h1>
            <p>Add, edit, and manage physiotherapist accounts.</p>
        </div>

        <!-- Add Physiotherapist -->
        <div class="management-card">

            <h2>Add Physiotherapist</h2>

            <form method="POST" class="management-form">

                <label>Full Name</label>
                <input type="text"
                       name="name"
                       placeholder="Enter full name"
                       required>

                <label>Email Address</label>
                <input type="email"
                       name="email"
                       placeholder="Enter email address"
                       required>

                <label>Password</label>
                <input type="password"
                       name="password"
                       placeholder="Enter password"
                       required>

                <button type="submit" class="btn-primary">
                    Add Physiotherapist
                </button>

            </form>

            <?php if ($message != ""): ?>
                <p class="form-message">
                    <?= htmlspecialchars($message) ?>
                </p>
            <?php endif; ?>

        </div>

        <!-- Physiotherapists Table -->
        <div class="management-card">

            <h2>Physiotherapists List</h2>

            <div class="table-container">

                <table class="management-table">

                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Actions</th>
                        </tr>
                    </thead>

                    <tbody>

                    <?php foreach ($physiotherapists as $physio): ?>
                        <tr>
                            <td><?= (int) $physio["id"] ?></td>

                            <td>
                                <?= htmlspecialchars($physio["name"]) ?>
                            </td>

                            <td>
                                <?= htmlspecialchars($physio["email"]) ?>
                            </td>

                            <td>
                                <div class="table-actions">

                                    <a class="btn-edit"
                                       href="edit-physiotherapist.php?id=<?= (int) $physio['id'] ?>">
                                        Edit
                                    </a>

                                    <form action="delete-physiotherapist.php"
                                          method="POST"
                                          onsubmit="return confirm('Are you sure you want to delete this physiotherapist?');">

                                        <input type="hidden"
                                               name="id"
                                               value="<?= (int) $physio['id'] ?>">

                                        <button type="submit" class="btn-delete">
                                            Delete
                                        </button>

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