<?php
session_start();

if (!isset($_SESSION["user_id"]) || $_SESSION["role"] != "admin") {
    header("Location: ../login.php");
    exit;
}

require_once __DIR__ . "/../classes/User.php";

if ($_SERVER["REQUEST_METHOD"] != "POST") {
    header("Location: physiotherapists.php");
    exit;
}

$user = new User();
$id = (int) ($_POST["id"] ?? 0);

if ($id <= 0) {
    exit("Invalid physiotherapist.");
}

if ($user->hasPhysiotherapistAppointments($id)) {
    exit("Cannot delete this physiotherapist because they have related appointments.
          <br><a href='physiotherapists.php'>Back to Physiotherapists</a>");
}

try {
    $user->deletePhysiotherapist($id);

    header("Location: physiotherapists.php");
    exit;

} catch (PDOException $e) {
    echo "Cannot delete this physiotherapist because they have related records.";
    echo '<br><a href="physiotherapists.php">Back to Physiotherapists</a>';
}
?>