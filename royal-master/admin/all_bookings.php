<?php
session_start();
$conn = mysqli_connect("localhost", "root", "", "royal");

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

$result = mysqli_query(
    $conn,
    "SELECT * FROM bookings WHERE user_id='$user_id' ORDER BY id DESC"
);

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>




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

        .col-lg-12 {
            margin-left: 276px;
        }
    </style>

</head>

<body>
    <?php include "layout/header.php"; ?>
    <?php include 'layout/sidebar.php'; ?>




    <div class="container-fluid" style="margin-top:140px;">
        <div class="row">
            <div class="col-lg-12">

                <h2 class="mb-4">All Bookings</h2>

                <div class="table-responsive">
                    <table class="table table-bordered table-striped text-center">
                        <thead class="thead-dark">
                            <tr>
                                <th>Room</th>
                                <th>name</th>
                                <th>email</th>
                                <th>Check-in</th>
                                <th>Check-out</th>
                                <th>Status</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                                <tr>
                                    <td><?= $row['room_id']; ?></td>
                                    <td><?= $row['name'] ?></td>
                                    <td><?= $row['email'] ?></td>
                                    <td><?= $row['checkin']; ?></td>
                                    <td><?= $row['checkout']; ?></td>


                                    <td>
                                        <?php
                                        $status = strtolower(trim($row['status']));

                                        if ($status == "pending") {
                                            echo "<span class='badge badge-warning'>Pending</span>";
                                        } elseif ($status == "confirmed") {
                                            echo "<span class='badge badge-success'>✔ Confirmed</span>";
                                        } elseif ($status == "rejected") {
                                            echo "<span class='badge badge-danger'>✖ Rejected</span>";
                                        } else {
                                            echo "<span class='badge badge-secondary'>Unknown</span>";
                                        }
                                        ?>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>

                    </table>
                </div>

            </div>
        </div>
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