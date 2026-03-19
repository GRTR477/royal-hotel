<?php
session_start();
$conn = mysqli_connect("localhost", "root", "", "royal");

if (!isset($_SESSION['admin_id'])) {
    header("Location: ../login.php");
    exit;
}

if (!isset($_GET['id']) || !isset($_GET['status'])) {
    die("Invalid Request");
}

$booking_id = $_GET['id'];
$status = $_GET['status'];

$admin_id = $_SESSION['admin_id'];

/* 1️⃣ UPDATE BOOKING STATUS */
mysqli_query($conn, "
    UPDATE bookings 
    SET status = '$status'
    WHERE id = '$booking_id'
");

/* 2️⃣ FETCH BOOKING DETAILS */
$booking = mysqli_query($conn, "
    SELECT user_id, room_id, checkin, checkout
    FROM bookings
    WHERE id = '$booking_id'
");

$b = mysqli_fetch_assoc($booking);

/* 3️⃣ INSERT INTO REPORTS TABLE */
mysqli_query($conn, "
    INSERT INTO reports
    (bookingid, userid, roomid, checkin, checkout, status, actionby)
    VALUES
    (
        '$booking_id',
        '{$b['userid']}',
        '{$b['roomid']}',
        '{$b['checkin']}',
        '{$b['checkout']}',
        '$status',
        '$admin_id'
    )
");

header("Location: bookings.php");
exit;
