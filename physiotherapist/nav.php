<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <nav class="patient-navbar">

    <h2 class="navbar-logo">PhysioCare</h2>

    <div class="navbar-links">
        <a href="../index.php">Home</a>
        <a href="dashboard.php">Dashboard</a>
        <a href="availability.php">Manage Availability</a>
        <a href="../logout.php">Logout</a>
    </div>

    <div class="navbar-user">
        Welcome,
        <strong><?= htmlspecialchars($_SESSION["name"]) ?></strong>
    </div>

</nav>
</body>
</html>