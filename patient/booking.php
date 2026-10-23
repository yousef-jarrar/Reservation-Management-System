
<?php
session_start();

if (!isset($_SESSION["user_id"]) || $_SESSION["role"] != "patient") {
    header("Location: ../login.php");
    exit;
}

require_once __DIR__ . "/../classes/Appointment.php";
require_once __DIR__ . "/../classes/TherapySession.php";

$physiotherapistId = (int) ($_GET["id"] ?? 0);

$appointment = new Appointment();
$therapySession = new TherapySession();

$sessions = $therapySession->getAllSessions();
$times = $appointment->getAvailableTimes($physiotherapistId);

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $availabilityId = (int) ($_POST["availability_id"] ?? 0);
    $sessionId = (int) ($_POST["session_id"] ?? 0);

    $selectedSession = $therapySession->getSessionById($sessionId);

    if (!$selectedSession) {

        $message = "Please select a valid session.";

    } else {

        try {

            $success = $appointment->bookAppointment(
                $_SESSION["user_id"],
                $sessionId,
                $availabilityId,
                $physiotherapistId
            );

            if ($success) {
                $message = "Appointment booked successfully!";
            } else {
                $message = "This appointment is no longer available.";
            }

        } catch (PDOException $e) {
            $message = "This appointment could not be booked.";
        }
    }

    $times = $appointment->getAvailableTimes($physiotherapistId);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Book Appointment</title>

    <link rel="stylesheet" href="../css/style.css?v=8">
</head>

<body>

<?php include __DIR__ . "/nav.php"; ?>

<main class="patient-main">

    <div class="dashboard-header">

        <h1>Book Appointment</h1>

        <p>Choose an available date and time for your therapy session.</p>

    </div>

    <div class="management-card">

        <h2>Booking Information</h2>

        <p>Select your preferred appointment from the available times below.</p>

        <?php if ($message != ""): ?>

            <p class="form-message">
                <?= htmlspecialchars($message) ?>
            </p>

        <?php endif; ?>

    </div>

    <div class="management-card">

        <h2>Available Appointments</h2>

        <?php if (count($times) > 0): ?>

            <div class="booking-grid">

                <?php foreach ($times as $time): ?>

                    <div class="booking-card">

                        <p>
                            <strong>Date:</strong>
                            <?= htmlspecialchars($time["available_date"]) ?>
                        </p>

                        <p>
                            <strong>Time:</strong>
                            <?= htmlspecialchars($time["available_time"]) ?>
                        </p>

                        <form method="POST">

                            <input
                                type="hidden"
                                name="availability_id"
                                value="<?= (int) $time["id"] ?>">

                            <label>Select Session</label>

                            <select name="session_id" required>

                                <option value="">Choose a session</option>

                                <?php foreach ($sessions as $session): ?>

                                    <option value="<?= (int) $session["id"] ?>">
                                        <?= htmlspecialchars($session["name"]) ?>
                                        -
                                        <?= (int) $session["duration"] ?> min
                                        -
                                        <?= htmlspecialchars($session["price"]) ?> JOD
                                    </option>

                                <?php endforeach; ?>

                            </select>

                            <button type="submit" class="btn-primary">
                                Book This Time
                            </button>

                        </form>

                    </div>

                <?php endforeach; ?>

            </div>

        <?php else: ?>

            <p>No available appointments.</p>

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
