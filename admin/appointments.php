<?php
session_start();

if (!isset($_SESSION["user_id"]) || $_SESSION["role"] != "admin") {
    header("Location: ../login.php");
    exit;
}

require_once __DIR__ . "/../classes/AdminAppointment.php";

$adminAppointment = new AdminAppointment();
$appointments = $adminAppointment->getAllAppointments();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View All Appointments</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>

<div class="dashboard-layout">

    <?php include __DIR__ . "/sidebar.php"; ?>

    <main class="dashboard-main">

        <div class="dashboard-header">
            <h1>View All Appointments</h1>
            <p>View all patient appointments in the system.</p>
        </div>

        <div class="management-card">
            <h2>All Appointments</h2>

            <?php if (count($appointments) > 0): ?>

                <div class="table-container">
                    <table class="management-table">
                        <thead>
                            <tr>
                                <th>Patient</th>
                                <th>Physiotherapist</th>
                                <th>Session</th>
                                <th>Date</th>
                                <th>Time</th>
                                <th>Status</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php foreach ($appointments as $appointment): ?>
                                <tr>
                                    <td><?= htmlspecialchars($appointment["patient_name"]) ?></td>
                                    <td><?= htmlspecialchars($appointment["physiotherapist_name"]) ?></td>
                                    <td><?= htmlspecialchars($appointment["session_name"]) ?></td>
                                    <td><?= htmlspecialchars($appointment["available_date"]) ?></td>
                                    <td><?= htmlspecialchars($appointment["available_time"]) ?></td>
                                    <td>
                                        <span class="status-badge status-<?= strtolower(htmlspecialchars($appointment["status"])) ?>">
                                            <?= htmlspecialchars($appointment["status"]) ?>
                                        </span>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

            <?php else: ?>
                <p>No appointments found.</p>
            <?php endif; ?>

        </div>

    </main>

</div>

</body>
</html>