<?php
session_start();

if (!isset($_SESSION["user_id"]) || $_SESSION["role"] != "physiotherapist") {
    header("Location: ../login.php");
    exit;
}

require_once __DIR__ . "/../classes/Availability.php";

$availability = new Availability();
$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $date = $_POST["date"] ?? "";
    $time = $_POST["time"] ?? "";

    if ($date >= date("Y-m-d") && $time != "") {

        $success = $availability->addAvailability(
            $_SESSION["user_id"],
            $date,
            $time
        );

        if ($success) {
            $message = "Availability added successfully!";
        }

    } else {
        $message = "Please choose a valid future date and time.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Manage Availability</title>

    <link rel="stylesheet" href="../css/style.css?v=8">
</head>

<body>

<?php include __DIR__ . "/nav.php"; ?>

<main class="patient-main">

    <div class="dashboard-header">

        <h1>Manage Availability</h1>

        <p>Add your available dates and times for patient appointments.</p>

    </div>

    <div class="management-card">

        <h2>Add Available Time</h2>

        <form method="POST" class="management-form">

            <label for="date">Available Date</label>

            <input
                type="date"
                id="date"
                name="date"
                min="<?= date('Y-m-d') ?>"
                required
            >

            <label for="time">Available Time</label>

            <input
                type="time"
                id="time"
                name="time"
                required
            >

            <button type="submit" class="btn-primary">
                Add Availability
            </button>

        </form>

        <?php if ($message != ""): ?>

            <p class="form-message">
                <?= htmlspecialchars($message) ?>
            </p>

        <?php endif; ?>

    </div>

    <p>
        <a href="dashboard.php">
            ← Back to Dashboard
        </a>
    </p>

</main>

</body>
</html>