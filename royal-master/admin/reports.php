<?php
session_start();
$conn = mysqli_connect("localhost", "root", "", "royal");

/* ADMIN LOGIN CHECK */
if (!isset($_SESSION['admin_id'])) {
    header("Location: ../login.php");
    exit;
}

/* USERS WHO HAVE REPORTS */
$users = mysqli_query($conn, "
    SELECT DISTINCT u.id, u.name
    FROM user u
    JOIN reports rp ON rp.userid = u.id
");

/* FILTER LOGIC */
$where = "WHERE 1";

if (isset($_GET['filter'])) {

    if (!empty($_GET['userid'])) {
        $userid = $_GET['userid'];
        $where .= " AND rp.userid = '$userid'";
    }

    if (!empty($_GET['from_date']) && !empty($_GET['to_date'])) {
        $from = $_GET['from_date'];
        $to   = $_GET['to_date'];
        $where .= " AND DATE(rp.actiontime) BETWEEN '$from' AND '$to'";
    }

    if (!empty($_GET['status'])) {
        $status = $_GET['status'];
        $where .= " AND rp.status = '$status'";
    }
}

/* REPORT QUERY */
$reports = mysqli_query($conn, "
    SELECT 
        rp.bookingid   AS bookingid,
        u.id           AS userid,
        u.name         AS username,
        u.email        AS email,
        r.room_name    AS roomname,
        rp.checkin     AS checkin,
        rp.checkout    AS checkout,
        rp.status      AS status,
        rp.actiontime  AS actiontime
    FROM reports rp
    JOIN user u ON u.id = rp.userid
    JOIN rooms r ON r.id = rp.roomid
    $where
    ORDER BY rp.actiontime DESC
");
?>

<!DOCTYPE html>
<html>

<head>
    <title>Booking Reports</title>
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
    </style>


</head>

<body>
    <?php include "layout/sidebar.php"; ?>
    <?php include "layout/header.php"; ?>
    <div class="container">

        <div class="nxl-content">
            <div class="main">


                <div class="content">

                    <h2>Room Booking Reports</h2>

                    <form method="get" style="margin-bottom:20px">

                        <select name="userid">
                            <option value="">Select User</option>
                            <?php while ($u = mysqli_fetch_assoc($users)) { ?>
                                <option value="<?= $u['id'] ?>"
                                    <?= (isset($_GET['userid']) && $_GET['userid'] == $u['id']) ? 'selected' : '' ?>>
                                    <?= $u['name'] ?>
                                </option>
                            <?php } ?>
                        </select>

                        <input type="date" name="from_date">
                        <input type="date" name="to_date">

                        <select name="status">
                            <option value="">All Status</option>
                            <option value="confirmed">Confirmed</option>
                            <option value="rejected">Rejected</option>
                        </select>

                        <button type="submit" name="filter">Generate Report</button>
                    </form>

                    <table>
                        <tr>
                            <th>Booking ID</th>
                            <th>User ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Room</th>
                            <th>Check In</th>
                            <th>Check Out</th>
                            <th>Status</th>
                            <th>Action Time</th>
                        </tr>

                        <?php if (mysqli_num_rows($reports) > 0) { ?>
                            <?php while ($row = mysqli_fetch_assoc($reports)) { ?>
                                <tr>
                                    <td><?= $row['bookingid'] ?></td>
                                    <td><?= $row['userid'] ?></td>
                                    <td><?= $row['username'] ?></td>
                                    <td><?= $row['email'] ?></td>
                                    <td><?= $row['roomname'] ?></td>
                                    <td><?= $row['checkin'] ?></td>
                                    <td><?= $row['checkout'] ?></td>
                                    <td>
                                        <?= $row['status'] == 'confirmed'
                                            ? "<span style='color:green;font-weight:bold'>Confirmed</span>"
                                            : "<span style='color:red;font-weight:bold'>Rejected</span>" ?>
                                    </td>
                                    <td><?= $row['actiontime'] ?></td>
                                </tr>
                            <?php } ?>
                        <?php } else { ?>
                            <tr>
                                <td colspan="9">No reports found</td>
                            </tr>
                        <?php } ?>

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