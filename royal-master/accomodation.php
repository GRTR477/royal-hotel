<?php
session_start();

$conn = mysqli_connect("localhost", "root", "", "royal");

if (!$conn) {
    die("connection failed");
}

// Hotel Accommodation
$hotelRooms = mysqli_query($conn,"SELECT * FROM rooms WHERE accommodation_type='hotel'");

// Normal Accommodation
$normalRooms = mysqli_query( $conn,"SELECT * FROM rooms WHERE accommodation_type='normal'");
?>




<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="icon" href="image/favicon.png" type="image/png">
    <title>Royal Hotel</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="vendors/linericon/style.css">
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <link rel="stylesheet" href="vendors/bootstrap-datepicker/bootstrap-datetimepicker.min.css">
    <link rel="stylesheet" href="vendors/nice-select/css/nice-select.css">
    <link rel="stylesheet" href="vendors/owl-carousel/owl.carousel.min.css">
    <!-- main css -->
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/responsive.css">
</head>

<body>
    <!--================Header Area =================-->
    <?php require_once __DIR__ . "/includes/header.php"; ?>
    <!--================Header Area =================-->

    <!--================Breadcrumb Area =================-->
    <section class="breadcrumb_area">
        <div class="overlay bg-parallax" data-stellar-ratio="0.8" data-stellar-vertical-offset="0" data-background=""></div>
        <div class="container">
            <div class="page-cover text-center">
                <h2 class="page-cover-tittle">Accomodation</h2>
                <ol class="breadcrumb">
                    <li><a href="index.php">Home</a></li>
                    <li class="active">Accomodation</li>
                </ol>
            </div>
        </div>
    </section>
    <!--================Breadcrumb Area =================-->

    <!--================ Accomodation Area  =================-->
    <section class="accomodation_area section_gap">
        <div class="container">
            <div class="section_title text-center">
                <h2 class="title_color">Hotel Accomodation</h2>
                <p>We all live in an age that belongs to the young at heart.</p>
            </div>

            <div class="row mb_30">

                <?php while ($row = mysqli_fetch_assoc($hotelRooms)) { ?>

                    <div class="col-lg-3 col-sm-6">
                        <div class="accomodation_item text-center">
                            <div class="hotel_img">
                                <!-- 👇 IMAGE DB SE -->
                                <img src="uploads/<?php echo $row['image']; ?>" alt="">

                                <!-- 👇 SAME BOOK NOW BUTTON -->
                                <a href="booking.php?room_id=<?php echo $row['id']; ?>"
                                    class="btn theme_btn button_hover">
                                    Book Now
                                </a>
                            </div>

                            <!-- 👇 ROOM NAME -->
                            <a href="#">
                                <h4 class="sec_h4">
                                    <?php echo $row['room_name']; ?>
                                </h4>
                            </a>

                            <!-- 👇 PRICE -->
                            <h5>
                                ₹<?php echo $row['price_per_night']; ?>
                                <small>/night</small>
                            </h5>
                        </div>
                    </div>

                <?php } ?>

            </div>
        </div>
    </section>
    <!--================ Accomodation Area  =================-->
    <!--================Booking Tabel Area =================-->
    <section class="hotel_booking_area">
        <div class="container">
            <div class="row hotel_booking_table">
                <div class="col-md-3">
                    <h2>Book<br> Your Room</h2>
                </div>
                <div class="col-md-9">
                    <div class="boking_table">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="book_tabel_item">
                                    <div class="form-group">
                                        <div class='input-group date' id='datetimepicker11'>
                                            <input type='text' class="form-control" placeholder="Arrival Date" />
                                            <span class="input-group-addon">
                                                <i class="fa fa-calendar" aria-hidden="true"></i>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class='input-group date' id='datetimepicker1'>
                                            <input type='text' class="form-control" placeholder="Departure Date" />
                                            <span class="input-group-addon">
                                                <i class="fa fa-calendar" aria-hidden="true"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="book_tabel_item">
                                    <div class="input-group">
                                        <select class="wide">
                                            <option data-display="Adult">Adult</option>
                                            <option value="1">Old</option>
                                            <option value="2">Younger</option>
                                            <option value="3">Potato</option>
                                        </select>
                                    </div>
                                    <div class="input-group">
                                        <select class="wide">
                                            <option data-display="Child">Child</option>
                                            <option value="1">Child</option>
                                            <option value="2">Baby</option>
                                            <option value="3">Child</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="book_tabel_item">
                                    <div class="input-group">
                                        <select class="wide">
                                            <option data-display="Child">Number of Rooms</option>
                                            <option value="1">Room 01</option>
                                            <option value="2">Room 02</option>
                                            <option value="3">Room 03</option>
                                        </select>
                                    </div>
                                    <a class="book_now_btn button_hover" href="#">Book Now</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--================Booking Tabel Area  =================-->
    <!--================ Accomodation Area  =================-->
    <!--================ Normal Accomodation Area  =================-->
    <section class="accomodation_area section_gap">
        <div class="container">
            <div class="section_title text-center">
                <h2 class="title_color">Normal Accomodation</h2>
                <p>We all live in an age that belongs to the young at heart.</p>
            </div>

            <div class="row accomodation_two">

                <?php if ($normalRooms && mysqli_num_rows($normalRooms) > 0) { ?>
                    <?php while ($row = mysqli_fetch_assoc($normalRooms)) { ?>

                        <div class="col-lg-3 col-sm-6">
                            <div class="accomodation_item text-center">
                                <div class="hotel_img">
                                    <img src="uploads/<?php echo $row['image']; ?>" alt="">
                                    <a href="booking.php?room_id=<?php echo $row['id']; ?>"
                                        class="btn theme_btn button_hover">
                                        Book Now
                                    </a>
                                </div>
                                <h4 class="sec_h4"><?php echo $row['room_name']; ?></h4>
                                <h5>₹<?php echo $row['price_per_night']; ?><small>/night</small></h5>
                            </div>
                        </div>

                    <?php } ?>
                <?php } else { ?>
                    <p class="text-center">No Normal Rooms Available</p>
                <?php } ?>

            </div>
        </div>
    </section>
    <!--================ Normal Accomodation Area  =================-->

    <!--================ Accomodation Area  =================-->
    <!--================ start footer Area  =================-->
    <?php require_once __DIR__ . "/includes/footer.php"; ?>
    <!--================ End footer Area  =================-->


    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="js/jquery-3.2.1.min.js"></script>
    <script src="js/popper.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="vendors/owl-carousel/owl.carousel.min.js"></script>
    <script src="js/jquery.ajaxchimp.min.js"></script>
    <script src="vendors/bootstrap-datepicker/bootstrap-datetimepicker.min.js"></script>
    <script src="vendors/nice-select/js/jquery.nice-select.js"></script>
    <script src="js/mail-script.js"></script>
    <script src="js/stellar.js"></script>
    <script src="vendors/lightbox/simpleLightbox.min.js"></script>
    <script src="js/custom.js"></script>
</body>

</html>