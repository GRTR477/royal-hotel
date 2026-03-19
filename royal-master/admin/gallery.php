<?php
session_start();

$conn = mysqli_connect("localhost", "root", "", "royal");

/* ADMIN LOGIN CHECK */
if (!isset($_SESSION['admin_id'])) {
    header("Location: ../login.php");
    exit;
}

$msg = "";

/* ================= ADD GALLERY ================= */
if (isset($_POST['add_gallery'])) {

    $imgName = time() . "_" . $_FILES['image']['name'];
    $tmp = $_FILES['image']['tmp_name'];
    $uploadDir = "../uploads/";

    if (move_uploaded_file($tmp, $uploadDir . $imgName)) {
        mysqli_query($conn, "
            INSERT INTO gallery (image, status)
            VALUES ('$imgName', 'active')
        ");
        $msg = "✅ Image Added Successfully";
    } else {
        $msg = "❌ Image Upload Failed";
    }
}

/* ================= DELETE GALLERY ================= */
if (isset($_GET['delete'])) {

    $id = $_GET['delete'];

    $getImg = mysqli_query($conn, "SELECT image FROM gallery WHERE id=$id");
    $img = mysqli_fetch_assoc($getImg);

    if ($img) {
        unlink("../uploads/" . $img['image']); // delete file
        mysqli_query($conn, "DELETE FROM gallery WHERE id=$id"); // delete db
    }

    header("Location: gallery.php");    
    exit;
}

/* ================= FETCH GALLERY ================= */
$gallery = mysqli_query($conn, "SELECT * FROM gallery ORDER BY id DESC");
?>

<!DOCTYPE html>
<html>

<head>
    <title>Admin Gallery</title>
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
            font-family: Arial;
            background: #f1f3f6
        }

        .header {
            margin-left: 272px;
        }

        .sidebar {
            width: 240px;
            background: #1f2937;
            color: #fff;

            padding: 30px 20px;
            margin-top: -161px;
        }

        .form-box {
            width: 1216px;
            margin: px auto;
            background: #fff;
            padding: 24px;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            margin-left: 267px;
        }

        ul.orders {
            margin-left: 294px;
        }

        .box {
            background: #fff;
            padding: 20px;
            margin: 20px;
            border-radius: 8px;
            margin-top: 100px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 30px;
        }

        th,
        td {
            padding: 10px;
            border-bottom: 1px solid #ddd;
            text-align: center
        }

        img {
            border-radius: 6px
        }

        button {
            padding: 8px 15px;
            background: #2563eb;
            color: #fff;
            border: none;
            border-radius: 5px
        }
    </style>





</head>

<body>
    <?php include "layout/header.php"; ?>
    <?php include "layout/sidebar.php"; ?>


    <div class="box" style="margin-left:260px">

        <h2>Add Gallery Image</h2>

        <?php if ($msg) echo "<p>$msg</p>"; ?>

        <form method="post" enctype="multipart/form-data">
            <input type="file" name="image" required>
            <button type="submit" name="add_gallery">Add Image</button>
        </form>

    </div>

    <div class="box1" style="margin-left:260px">

        <h2>Gallery Images</h2>

        <table>
            <tr>
                <th>ID</th>
                <th>Image</th>
                <th>Status</th>
                <th>Action</th>
            </tr>

            <?php while ($row = mysqli_fetch_assoc($gallery)) { ?>
                <tr>
                    <td><?= $row['id'] ?></td>
                    <td>
                        <img src="../uploads/<?= $row['image'] ?>" width="120">
                    </td>
                    <td><?= $row['status'] ?></td>
                    <td>
                        <a href="gallery.php?delete=<?= $row['id'] ?>"
                            onclick="return confirm('Delete this image?')">
                            Delete
                        </a>
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