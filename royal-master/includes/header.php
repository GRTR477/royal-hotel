<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Royal Hotel</title>

    <!-- BOOTSTRAP & THEME CSS -->
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="vendors/linericon/style.css">
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <link rel="stylesheet" href="vendors/owl-carousel/owl.carousel.min.css">
    <link rel="stylesheet" href="vendors/bootstrap-datepicker/bootstrap-datetimepicker.min.css">
    <link rel="stylesheet" href="vendors/nice-select/css/nice-select.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/responsive.css">
</head>

<body>

    <header class="header_area">
        <div class="container">
            <nav class="navbar navbar-expand-lg navbar-light">
                <!-- Brand and toggle get grouped for better mobile display -->
                <a class="navbar-brand logo_h" href="index.php"><img src="image/Logo.png" alt=""></a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse offset" id="navbarSupportedContent">
                    <ul class="nav navbar-nav menu_nav ml-auto">
                        <li class="nav-item active">
                            <a class="nav-link" href="./">Home</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="about">About us</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="accomodation">Accomodation</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="gallry">Gallery</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="contact">Contact</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="mybookings">My Bookings</a>
                        </li>

                        <?php if (isset($_SESSION['user_id'])) { ?>

                            <li class="nav-item">
                                <span class="nav-link"><b><?= $_SESSION['user_name'] ?></b></span>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link" href="logout.php">Logout</a>
                            </li>

                        <?php } else { ?>

                            <li class="nav-item">
                                <a class="nav-link" href="login">Login</a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link" href="register">Signup</a>
                            </li>

                        <?php } ?>

                    </ul>
                </div>
            </nav>
        </div>
    </header>