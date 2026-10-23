<?php
session_start();

if (!isset($_SESSION["user_id"]) || $_SESSION["role"] != "admin") {
    header("Location: ../login.php");
    exit;
}

require_once __DIR__ . "/../classes/AdminStats.php";

$stats = new AdminStats();

$totalPatients = $stats->countPatients();
$totalPhysiotherapists = $stats->countPhysiotherapists();
$totalSessions = $stats->countSessions();
$totalAppointments = $stats->countAppointments();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>

<div class="dashboard-layout">

    <?php include __DIR__ . "/sidebar.php"; ?>

    <main class="dashboard-main">

        <div class="dashboard-header">
            <h1>Admin Dashboard</h1>
            <p>Welcome, <?= htmlspecialchars($_SESSION["name"]) ?>!</p>
        </div>

        <h2>Overview</h2>

        <div class="dashboard-cards">

            <div class="dashboard-card">
                <h3>Total Patients</h3>
                <p><?= $totalPatients ?></p>
            </div>

            <div class="dashboard-card">
                <h3>Total Physiotherapists</h3>
                <p><?= $totalPhysiotherapists ?></p>
            </div>

            <div class="dashboard-card">
                <h3>Total Sessions</h3>
                <p><?= $totalSessions ?></p>
            </div>

            <div class="dashboard-card">
                <h3>Total Appointments</h3>
                <p><?= $totalAppointments ?></p>
            </div>

        </div>

        <h2>Management</h2>

        <div class="dashboard-cards">

            <div class="dashboard-card">
                <h3>Physiotherapists</h3>
                <p>Manage physiotherapist accounts.</p>

                <a href="physiotherapists.php">
                    Manage Physiotherapists →
                </a>
            </div>

            <div class="dashboard-card">
                <h3>Therapy Sessions</h3>
                <p>Manage therapy sessions and prices.</p>

                <a href="sessions.php">
                    Manage Sessions →
                </a>
            </div>

            <div class="dashboard-card">
                <h3>Appointments</h3>
                <p>View all patient appointments in the system.</p>

                <a href="appointments.php">
                    View All Appointments →
                </a>
            </div>

        </div>

    </main>

</div>

</body>
</html>