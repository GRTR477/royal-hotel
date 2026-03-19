<?php
session_start();
$conn = mysqli_connect("localhost", "root", "", "royal");

if (!isset($_SESSION['admin_id'])) {
    header("Location: ../login.php");
    exit();
}

if (isset($_POST['add_room'])) {

    $name  = $_POST['room_name'];
    $type  = $_POST['room_type'];
    $price = $_POST['price'];
    $total = $_POST['total_rooms'];
    $accommodation_type = $_POST['accommodation_type'];
    $img  = $_FILES['image']['name'];
    $tmp  = $_FILES['image']['tmp_name'];

    $uploadDir = __DIR__ . "/../uploads/";

    if (!is_dir($uploadDir)) {
        die("Uploads folder not found: " . $uploadDir);
    }

    $imgName = time() . "_" . $_FILES['image']['name'];
    $uploadPath = "../uploads/" . $imgName;

    move_uploaded_file($_FILES['image']['tmp_name'], $uploadPath);

    mysqli_query($conn, "
    INSERT INTO rooms 
    (room_name, room_type, price_per_night, total_rooms, image, accommodation_type)
    VALUES 
    ('$name','$type','$price','$total','$imgName','$accommodation_type')
");



    $msg = "Room Added Successfully";
}




?>
<!DOCTYPE html>
<html>

<head>
    <title>Add Room</title>
    <link rel="stylesheet" href="assets/css/admin-layout.css">
    <style>
        /* ===== RESET ===== */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: "Segoe UI", sans-serif
        }

        body {
            background: #f1f5f9
        }

        /* ===== SIDEBAR ===== */
        .nxl-navigation {
            position: fixed;
            left: 0;
            top: 0;
            width: 260px;
            height: 100vh;
            background: #0f172a;
            color: #fff;
        }

        .m-header {
            padding: 18px;
            text-align: center;
            background: #020617;
            font-size: 20px;
            font-weight: 600
        }

        .nxl-navbar {
            list-style: none;
            padding: 10px 0
        }

        .nxl-link {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 14px 22px;
            color: #cbd5e1;
            text-decoration: none;
            cursor: pointer
        }

        .nxl-link:hover {
            background: #1e293b;
            color: #fff
        }

        .nxl-arrow {
            margin-left: auto;
            transition: .3s
        }

        /* dropdown */
        .nxl-submenu {
            display: none;
            background: #020617
        }

        .nxl-submenu .nxl-link {
            padding: 12px 55px;
            font-size: 14px;
            color: #94a3b8
        }

        .nxl-hasmenu.active>.nxl-submenu {
            display: block
        }

        .nxl-hasmenu.active>.nxl-link .nxl-arrow {
            transform: rotate(90deg)
        }

        /* ===== HEADER ===== */
        .nxl-header {
            position: fixed;
            left: 260px;
            top: 0;
            right: 0;
            height: 64px;
            background: #fff;
            border-bottom: 1px solid #e5e7eb;
            display: flex;
            align-items: center;
            padding: 0 25px
        }

        .header-right {
            margin-left: auto;
            font-weight: 600
        }

        /* ===== CONTENT ===== */
        .nxl-content {
            margin-left: 260px;
            padding: 90px 30px 30px
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background: #fff
        }

        th,
        td {
            padding: 12px;
            border-bottom: 1px solid #e5e7eb;
            text-align: left
        }

        th {
            background: #1e293b;
            color: #fff
        }






        body {
            background: #f1f3f6;
            font-family: Arial, sans-serif;
        }

        .form-box {
            width: 420px;
            margin: 80px auto;
            background: #fff;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .form-box h2 {
            margin-bottom: 20px;
            text-align: center;
        }

        .form-box input,
        .form-box select {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }



        ul.orders {
            margin-left: 294px;
        }

        .form-box {
            width: 1216px;
            margin: 10px auto;
            background: #fff;
            padding: 24px;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            margin-left: 267px;
        }


        .header {
            margin-left: 269px;
        }

        .sidebar {

            margin-top: -161px;
        }

        .form-box button {
            width: 100%;
            padding: 10px;
            background: #2563eb;
            border: none;
            color: #fff;
            font-size: 16px;
            border-radius: 5px;
            cursor: pointer;
        }

        .form-box button:hover {
            background: #1e40af;
        }

        .success {
            color: green;
            text-align: center;
            margin-bottom: 10px;
        }

        /* ===== TABLE ===== */
        table {
            width: 100%;
            border-collapse: collapse;
        }

        th {
            background: #1f2937;
            color: #fff;
            padding: 12px;
            font-size: 14px;
        }

        td {
            padding: 12px;
            border-bottom: 1px solid #e5e7eb;
            font-size: 14px;
        }

        tr:hover {
            background: #f9fafb;
        }
    </style>
</head>

<body>
    <?php include "layout/header.php"; ?>
    <?php include 'layout/sidebar.php'; ?>

    <div class="form-box">
        <h2>Add Room</h2>

        <?php if (isset($msg)) echo "<p class='success'>$msg</p>"; ?>

        <form method="post" enctype="multipart/form-data">
            <input type="text" name="room_name" placeholder="Room Name" required>

            <select name="room_type" required>
                <option value="">Select Room Type</option>
                <option>AC</option>
                <option>Non-AC</option>
                <option>Deluxe</option>
                <option>Suite</option>
            </select>

            <select name="accommodation_type">
                <option value="hotel">Hotel Accommodation</option>
                <option value="normal">Normal Accommodation</option>
            </select>

            <input type="number" name="price" placeholder="Price per night" required>

            <input type="number" name="total_rooms" placeholder="Total Rooms" required>

            <input type="file" name="image" required>

            <button type="submit" name="add_room">Add Room</button>

        </form>
    </div>
    <script>
        document.querySelectorAll(".nxl-hasmenu > .nxl-link").forEach(menu => {
            menu.addEventListener("click", () => {
                document.querySelectorAll(".nxl-hasmenu").forEach(i => {
                    if (i !== menu.parentElement) i.classList.remove("active");
                });
                menu.parentElement.classList.toggle("active");
            });
        });
    </script>
</body>

</html>