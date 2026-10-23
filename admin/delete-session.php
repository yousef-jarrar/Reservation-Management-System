<?php
session_start();

if (!isset($_SESSION["user_id"]) || $_SESSION["role"] != "admin") {
    header("Location: ../login.php");
    exit;
}

require_once __DIR__ . "/../classes/TherapySession.php";

if ($_SERVER["REQUEST_METHOD"] != "POST") {
    header("Location: sessions.php");
    exit;
}

$therapySession = new TherapySession();
$id = (int) ($_POST["id"] ?? 0);

if ($id <= 0) {
    exit("Invalid session.");
}

if ($therapySession->hasAppointments($id)) {
    exit("Cannot delete this session because it has related appointments.
          <br><a href='sessions.php'>Back to Sessions</a>");
}

try {
    $therapySession->deleteSession($id);

    header("Location: sessions.php");
    exit;

} catch (PDOException $e) {
    echo "Unable to delete this session.";
    echo '<br><a href="sessions.php">Back to Sessions</a>';
}
?>