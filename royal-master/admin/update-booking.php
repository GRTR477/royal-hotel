<?php
session_start();
$conn = mysqli_connect("localhost", "root", "", "royal");

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

$bookingid = $_GET['id'];
$status    = $_GET['status'];
$adminid   = $_SESSION['admin_id'];

if ($status == 'confirmed' || $status == 'rejected') {

    /* 1️⃣ UPDATE BOOKING STATUS */
    mysqli_query($conn, "
        UPDATE bookings 
        SET status = '$status' 
        WHERE id = '$bookingid'
    ");

    /* 2️⃣ FETCH BOOKING DATA */
    $q = mysqli_query($conn, "
        SELECT user_id, room_id, checkin, checkout
        FROM bookings
        WHERE id = '$bookingid'
    ");
    $b = mysqli_fetch_assoc($q);

    /* 3️⃣ CHECK DUPLICATE REPORT */
    $check = mysqli_query($conn, "
        SELECT id FROM reports WHERE bookingid = '$bookingid'
    ");

    if (mysqli_num_rows($check) == 0) {

        /* 4️⃣ INSERT INTO REPORTS */
        mysqli_query($conn, "
    INSERT INTO reports
    (bookingid, userid, roomid, checkin, checkout, status, actionby)
    VALUES
    (
        '$bookingid',
        '{$b['user_id']}',
        '{$b['room_id']}',
        '{$b['checkin']}',
        '{$b['checkout']}',
        '$status',
        '$adminid'
    )
");
    }
}

header("Location: bookings.php");
exit();
