<?php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['user_id'] <= 0) {
    die("USER NOT LOGGED IN");
}

$user_id = (int)$_SESSION['user_id'];

$conn = mysqli_connect("localhost", "root", "", "royal");

if (!$conn) {
    die("DB Connection Failed");
}

// room id check
if (!isset($_GET['room_id'])) {
    header("Location: accommodation.php");
    exit();
}

$room_id = $_GET['room_id'];

// room fetch
$room_q = mysqli_query($conn, "SELECT * FROM rooms WHERE id='$room_id'");
$room = mysqli_fetch_assoc($room_q);

if (!$room) {
    echo "Room not found";
    exit();
}

$message = "";

// booking submit
if (isset($_POST['confirm_booking'])) {

    $name     = $_POST['name'];
    $email    = $_POST['email'];
    $checkin  = $_POST['checkin'];
    $checkout = $_POST['checkout'];

    if ($checkin >= $checkout) {
        $message = "Check-out date must be after check-in date";
    } else {

        mysqli_query($conn, "
          INSERT INTO bookings 
(room_id, name, email, checkin, checkout, user_id, status)
VALUES 
('$room_id', '$name', '$email', '$checkin', '$checkout', '$user_id', 'pending')
");

        header("Location: booking-waiting.php");
        exit();
    }
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>Book Room</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
<style>
 Page Background */
.booking-wrapper {
    min-height: 100vh;
    background: linear-gradient(120deg, #f5f7fa, #e4ecf7);
    padding: 60px 20px;
}

/* Room Card */
.room-card {
    background: #fff;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 10px 30px rgba(0,0,0,0.1);
}

.room-card img {
    width: 100%;
    height: 260px;
    object-fit: cover;
}

.room-info {
    padding: 20px;
}

.room-info h3 {
    font-weight: 600;
    margin-bottom: 8px;
}

.room-info .price {
    font-size: 22px;
    font-weight: bold;
    color: #28a745;
}

.room-info .price span {
    font-size: 14px;
    color: #777;
}

/* Booking Form Card */
.booking-card {
    background: #fff;
    border-radius: 12px;
    padding: 35px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.1);
}

.booking-card h2 {
    font-weight: 600;
    margin-bottom: 5px;
}

.booking-card .sub-text {
    color: #666;
    margin-bottom: 25px;
}

/* Form Fields */
.booking-card label {
    font-weight: 500;
    margin-bottom: 5px;
}

.booking-card .form-control {
    height: 45px;
    border-radius: 8px;
}

/* Button */
.btn-book {
    background: linear-gradient(135deg, #28a745, #218838);
    color: #fff;
    font-weight: 600;
    padding: 12px;
    border-radius: 8px;
    border: none;
    transition: 0.3s;
}

.justify-content-center {
    -ms-flex-pack: center !important;
    justify-content: center !important;
    margin-top: 130px;
}

.btn-book:hover {
    background: linear-gradient(135deg, #218838, #1e7e34);
}
</style>

</head>

<body>
  <?php require_once __DIR__ . "/includes/header.php"; ?>
     <div class="container-fluid booking-wrapper">
        <div class="row justify-content-center">

            <!-- ROOM DETAIL -->
            <div class="col-lg-4 col-md-5 mb-4">
                <div class="room-card">
                    <img src="uploads/<?= $room['image'] ?>" alt="Room Image">

                    <div class="room-info">
                        <h3><?= $room['room_name'] ?></h3>
                        <p class="price">₹ <?= $room['price_per_night'] ?> <span>/ night</span></p>
                    </div>
                </div>
            </div>

            <!-- BOOKING FORM -->
            <div class="col-lg-6 col-md-7">
                <div class="booking-card">

                    <h2>Confirm Your Booking</h2>
                    <p class="sub-text">Fill the details below to reserve your room</p>

                    <?php if ($message) { ?>
                        <div class="alert alert-danger"><?= $message ?></div>
                    <?php } ?>

                    <form method="post">

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label>Your Name</label>
                                <input type="text" name="name" class="form-control" required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label>Email Address</label>
                                <input type="email" name="email" class="form-control" required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label>Check In</label>
                                <input type="date" name="checkin" class="form-control" required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label>Check Out</label>
                                <input type="date" name="checkout" class="form-control" required>
                            </div>
                        </div>

                        <button name="confirm_booking" class="btn btn-book w-100">
                            CONFIRM BOOKING
                        </button>

                    </form>

                </div>
            </div>

        </div>
    </div>
 <?php require_once __DIR__ . "/includes/footer.php"; ?>
</body>

</html>