<?php
session_start();

if (!isset($_SESSION["user_id"]) || $_SESSION["role"] != "patient") {
    header("Location: ../login.php");
    exit;
}

require_once __DIR__ . "/../classes/Appointment.php";

$appointment = new Appointment();

$appointments = $appointment->getPatientAppointments($_SESSION["user_id"]);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>My Appointments</title>

    <link rel="stylesheet" href="../css/style.css?v=8">
</head>

<body>

<?php include __DIR__ . "/nav.php"; ?>

<main class="patient-main">

    <div class="dashboard-header">

        <h1>My Appointments</h1>

        <p>View your therapy appointments and their current status.</p>

    </div>

    <div class="management-card">

        <h2>Appointment History</h2>

        <?php if (count($appointments) > 0): ?>

            <div class="table-container">

                <table class="management-table">

                    <thead>
                        <tr>
                            <th>Physiotherapist</th>
                            <th>Session</th>
                            <th>Date</th>
                            <th>Time</th>
                            <th>Status</th>
                        </tr>
                    </thead>

                    <tbody>

                        <?php foreach ($appointments as $item): ?>

                            <tr>

                                <td>
                                    <?= htmlspecialchars($item["physiotherapist_name"]) ?>
                                </td>

                                <td>
                                    <?= htmlspecialchars($item["session_name"]) ?>
                                </td>

                                <td>
                                    <?= htmlspecialchars($item["available_date"]) ?>
                                </td>

                                <td>
                                    <?= htmlspecialchars($item["available_time"]) ?>
                                </td>

                                <td>
                                    <span class="status-badge status-<?= strtolower(htmlspecialchars($item["status"])) ?>">
                                        <?= htmlspecialchars($item["status"]) ?>
                                    </span>
                                </td>

                            </tr>

                        <?php endforeach; ?>

                    </tbody>

                </table>

            </div>

        <?php else: ?>

            <p>You have no appointments yet.</p>

        <?php endif; ?>

    </div>

    <p>
        <a href="physiotherapists.php">
            ← Back to Physiotherapists
        </a>
    </p>

</main>

</body>
</html>