<?php
session_start();
$conn = mysqli_connect("localhost", "root", "", "royal");

// admin login check
if (!isset($_SESSION['admin_id'])) {
  header("Location: login.php");
  exit();
}

$result = mysqli_query($conn, "
  SELECT b.*, r.room_name
  FROM bookings b
  JOIN rooms r ON b.room_id = r.id
  WHERE b.status = 'pending'
");
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
  <?php include "layout/header.php"; ?>
  <?php include 'layout/sidebar.php'; ?>

  <div class="nxl-content">
    <table border="1" cellpadding="10">
      <tr>
        <th>Customer</th>
        <th>Room</th>
        <th>Check-in</th>
        <th>Check-out</th>
        <th>Action</th>
      </tr>

      <?php while ($row = mysqli_fetch_assoc($result)) { ?>
        <tr>
          <td><?= $row['name'] ?></td>
          <td><?= $row['room_name'] ?></td>
          <td><?= $row['checkin'] ?></td>
          <td><?= $row['checkout'] ?></td>
          <td>
            <a href="booking_action.php?id=<?= $row['id'] ?>&status=confirmed">Confirm</a>
           / <a href="booking_action.php?id=<?= $row['id'] ?>&status=rejected">Reject</a>

          </td>
        </tr>
      <?php } ?>
    </table>

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