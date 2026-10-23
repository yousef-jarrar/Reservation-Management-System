<?php
session_start();

if (!isset($_SESSION["user_id"]) || $_SESSION["role"] != "physiotherapist") {
    header("Location: ../login.php");
    exit;
}

require_once __DIR__ . "/../classes/Appointment.php";

$appointment = new Appointment();

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $appointmentId = (int) ($_POST["appointment_id"] ?? 0);
    $status = $_POST["status"] ?? "";

    $success = $appointment->updateAppointmentStatus(
        $appointmentId,
        $_SESSION["user_id"],
        $status
    );

    if ($success) {
        $message = "Appointment status updated successfully!";
    } else {
        $message = "Unable to update appointment.";
    }
}

$appointments = $appointment->getPhysiotherapistAppointments($_SESSION["user_id"]);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Physiotherapist Dashboard</title>

    <link rel="stylesheet" href="../css/style.css?v=8">
</head>

<body>

<?php include __DIR__ . "/nav.php"; ?>

<main class="patient-main">

    <div class="dashboard-header">

        <h1>Physiotherapist Dashboard</h1>

        <p>Manage your patient appointments and booking requests.</p>

    </div>

    <div class="management-card">

        <h2>My Appointments</h2>

        <?php if ($message != ""): ?>

            <p class="form-message">
                <?= htmlspecialchars($message) ?>
            </p>

        <?php endif; ?>

        <?php if (count($appointments) > 0): ?>

            <div class="table-container">

                <table class="management-table">

                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Patient</th>
                            <th>Session</th>
                            <th>Date</th>
                            <th>Time</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>

                    <tbody>

                    <?php foreach ($appointments as $item): ?>

                        <tr>

                            <td>
                                <?= (int) $item["id"] ?>
                            </td>

                            <td>
                                <?= htmlspecialchars($item["patient_name"]) ?>
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

                            <td>

                                <?php if ($item["status"] == "Pending"): ?>

                                    <form method="POST" class="table-actions">

                                        <input
                                            type="hidden"
                                            name="appointment_id"
                                            value="<?= (int) $item["id"] ?>"
                                        >

                                        <button
                                            type="submit"
                                            name="status"
                                            value="Accepted"
                                            class="btn-accept"
                                        >
                                            Accept
                                        </button>

                                        <button
                                            type="submit"
                                            name="status"
                                            value="Rejected"
                                            class="btn-delete"
                                        >
                                            Reject
                                        </button>

                                    </form>

                                <?php else: ?>

                                    No actions

                                <?php endif; ?>

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

</body>
</html>