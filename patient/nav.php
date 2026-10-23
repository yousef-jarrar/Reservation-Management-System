<nav class="patient-navbar">

    <h2 class="navbar-logo">PhysioCare</h2>

    <div class="navbar-links">

        <a href="../index.php">Home</a>

        <a href="physiotherapists.php">Find Physiotherapists</a>

        <a href="appointments.php">My Appointments</a>

        <a href="../logout.php">Logout</a>

    </div>

    <div class="navbar-user">
        Welcome,
        <strong><?= htmlspecialchars($_SESSION["name"]) ?></strong>
    </div>

</nav>