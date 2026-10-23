<?php
session_start();

if (!isset($_SESSION["user_id"]) || $_SESSION["role"] != "patient") {
    header("Location: ../login.php");
    exit;
}

require_once "../classes/User.php";

$user = new User();
$physiotherapists = $user->getPhysiotherapists();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Available Physiotherapists</title>

    <link rel="stylesheet" href="../css/style.css?v=7">
</head>

<body>

<?php include __DIR__ . "/nav.php"; ?>

<main class="patient-main">

    <div class="dashboard-header">

        <h1>Find a Physiotherapist</h1>

        <p>Choose a physiotherapist and book your appointment.</p>

    </div>

    <h2>Available Physiotherapists</h2>

    <div class="physio-grid">

        <?php foreach ($physiotherapists as $physio): ?>

            <div class="physio-card">

                <div class="physio-avatar">
                    PT
                </div>

                <h3>
                    <?= htmlspecialchars($physio["name"]) ?>
                </h3>

                <p class="physio-role">
                    Physiotherapist
                </p>

                <p class="physio-email">
                    <?= htmlspecialchars($physio["email"]) ?>
                </p>

                <a
                    href="booking.php?id=<?= (int) $physio["id"] ?>"
                    class="physio-book-btn"
                >
                    Book Appointment
                </a>

            </div>

        <?php endforeach; ?>

    </div>

</main>

</body>
</html>