<?php
session_start();

$loggedIn = isset($_SESSION["user_id"]);
$role = $_SESSION["role"] ?? "";

$dashboardLink = "";

if ($role == "patient") {
    $dashboardLink = "patient/physiotherapists.php";
} elseif ($role == "physiotherapist") {
    $dashboardLink = "physiotherapist/dashboard.php";
} elseif ($role == "admin") {
    $dashboardLink = "admin/dashboard.php";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>PhysioCare | Home</title>

    <link rel="stylesheet" href="css/style.css">

    <style>
        .home-hero {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 50px;
            padding: 80px 6%;
            min-height: 550px;
        }

        .hero-content {
            flex: 1;
        }

        .hero-content h1 {
            font-size: 44px;
            color: #1E3A5F;
            margin-bottom: 20px;
        }

        .hero-content h1 span {
            color: #0284C7;
        }

        .hero-content p {
            font-size: 18px;
            color: #64748b;
            line-height: 1.8;
            margin-bottom: 30px;
        }

        .hero-buttons {
            display: flex;
            gap: 15px;
            flex-wrap: wrap;
        }

        .hero-buttons a {
            text-decoration: none;
            padding: 13px 25px;
            border-radius: 8px;
            font-weight: bold;
        }

        .home-btn-primary {
            background: #0284C7;
            color: white;
        }

        .home-btn-secondary {
            background: #DFF7F3;
            color: #1E3A5F;
        }

        .hero-image {
            flex: 1;
        }

        .hero-image img {
            width: 100%;
            border-radius: 20px;
            object-fit: cover;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.12);
        }

        .home-about {
            text-align: center;
            padding: 65px 10%;
            background: white;
        }

        .home-about h2 {
            font-size: 32px;
            color: #1E3A5F;
            margin-bottom: 20px;
        }

        .home-about p {
            font-size: 17px;
            color: #64748b;
            line-height: 1.9;
            max-width: 850px;
            margin: auto;
        }

        .home-footer {
            text-align: center;
            padding: 25px;
            background: #1E3A5F;
            color: white;
        }

        @media (max-width: 768px) {
            .home-hero {
                flex-direction: column;
                padding: 50px 6%;
                text-align: center;
            }

            .hero-content h1 {
                font-size: 32px;
            }

            .hero-buttons {
                justify-content: center;
            }
        }
    </style>

</head>

<body>

<!-- Navbar -->
<nav class="patient-navbar">

    <h2 class="navbar-logo">PhysioCare</h2>

    <div class="navbar-links">

        <a href="index.php">Home</a>

        <?php if ($loggedIn): ?>

            <a href="<?= htmlspecialchars($dashboardLink) ?>">Dashboard</a>

            <a href="logout.php">Logout</a>

        <?php else: ?>

            <a href="login.php">Login</a>

            <a href="register.php">Register</a>

        <?php endif; ?>

    </div>

</nav>


<!-- Hero Section -->
<section class="home-hero">

    <div class="hero-content">

        <h1>
            Welcome to <span>PhysioCare</span>
        </h1>

        <p>
            Your health and recovery are our priority.
            PhysioCare is an online physiotherapy appointment
            platform that helps patients connect with professional
            physiotherapists, explore available therapy sessions,
            and book appointments easily.
        </p>

        <div class="hero-buttons">

            <?php if ($loggedIn): ?>

                <a href="<?= htmlspecialchars($dashboardLink) ?>" class="home-btn-primary">
                    Go to Dashboard
                </a>

            <?php else: ?>

                <a href="register.php" class="home-btn-primary">
                    Get Started
                </a>

                <a href="login.php" class="home-btn-secondary">
                    Login
                </a>

            <?php endif; ?>

        </div>

    </div>

    <div class="hero-image">

        <img src="imege/imeges.jpg" alt="PhysioCare">

    </div>

</section>


<!-- About Section -->
<section class="home-about">

    <h2>About PhysioCare</h2>

    <p>
        PhysioCare is a web-based platform designed to simplify
        physiotherapy appointment management.

        Our platform allows patients to find physiotherapists,
        select suitable therapy sessions, and book available
        appointments online.

        Physiotherapists can manage their availability and
        appointment requests, while administrators can manage
        physiotherapists, therapy sessions, and appointments
        through an organized dashboard.
    </p>

</section>


<!-- Footer -->
<footer class="home-footer">

    <p>© <?= date("Y") ?> PhysioCare. All Rights Reserved.</p>

</footer>

</body>
</html>