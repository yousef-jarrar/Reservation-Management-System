<?php
$currentPage = basename($_SERVER["PHP_SELF"]);
?>

<aside class="sidebar">
    <h2 class="sidebar-logo">PhysioCare</h2>

    <nav>
        <a href="../index.php">Home</a>
        <a href="dashboard.php" class="<?= $currentPage == 'dashboard.php' ? 'active' : '' ?>">
            Dashboard
        </a>

        <a href="physiotherapists.php" class="<?= $currentPage == 'physiotherapists.php' ? 'active' : '' ?>">
            Manage Physiotherapists
        </a>

        <a href="sessions.php" class="<?= $currentPage == 'sessions.php' ? 'active' : '' ?>">
            Manage Sessions
        </a>

        <a href="appointments.php" class="<?= $currentPage == 'appointments.php' ? 'active' : '' ?>">
            View All Appointments
        </a>

        <a href="../logout.php">Logout</a>
    </nav>
</aside>