<?php
session_start();

$conn = mysqli_connect("localhost", "root", "", "royal");

if (!$conn) {
    die("connection failed");
}

if (!isset($_SESSION['admin_id'])) {
    header("Location: ../login.php");
    exit();
}

// 🔥 YAHI LINE MISSING THI
$messages = mysqli_query($conn, "
    SELECT * FROM contact_messages 
    ORDER BY id DESC
");


include "layout/header.php";
include "layout/sidebar.php";
?>



<!DOCTYPE html>
<html>

<head>
    <title>Contact Messages</title>
    <link rel="stylesheet" href="assets/css/admin-layout.css">
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid #ccc;
            padding: 10px;
        }

        th {
            background: #2563eb;
            color: #fff;
        }

        .header {
            margin-left: 269px;
        }



        /* ===== STATS ===== */
        .stats {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 20px;
            margin: 25px 0;
        }

        .stat-box {
            background: #fff;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        }

        .stat-box h3 {
            font-size: 22px;
        }

        .stat-box span {
            color: #6b7280;
            font-size: 14px;
        }

        /* ===== CONTENT ===== */
        .content {
            background: #fff;
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        }

        .content h3 {
            margin-bottom: 15px;
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

        .sidebar {
            width: 240px;
            background: #1f2937;
            color: #fff;

            padding: 30px 20px;
            margin-top: -161px;
        }

        ul.orders {
            margin-left: 294px;
        }

        .form-box {
            width: 1216px;
            margin: -716px auto;
            background: #fff;
            padding: 24px;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            margin-left: 267px;
        }




        .container {
            display: flex;
            min-height: 3vh;
            margin-left: 270px;
            margin-top: -700;
        }
    </style>
</head>

<body>



    <div class="container">





        <table>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Message</th>
                <th>Date</th>
            </tr>



            <?php if (mysqli_num_rows($messages) > 0) { ?>
                <?php while ($row = mysqli_fetch_assoc($messages)) { ?>
                    <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo $row['name']; ?></td>
                        <td><?php echo $row['email']; ?></td>
                        <td><?php echo $row['message']; ?></td>
                        <td><?php echo $row['created_at']; ?></td>
                    </tr>
                <?php } ?>
            <?php } else { ?>
                <tr>
                    <td colspan="5">No Messages Found</td>
                </tr>
            <?php } ?>

        </table>

    </div>

</body>

</html>