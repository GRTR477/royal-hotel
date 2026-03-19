<?php
session_start();
$conn = mysqli_connect("localhost", "root", "", "royal");

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];



$result = mysqli_query($conn, "
SELECT 
    b.checkin,
    b.checkout,
    b.status,
    room_id
FROM bookings b
JOIN rooms r ON r.id = b.room_id
WHERE b.user_id = '$user_id'
ORDER BY b.id DESC
");

require_once __DIR__ . "/includes/header.php";
?>

<div class="container-fluid" style="margin-top:140px;">
    <div class="row">
        <div class="col-lg-12">

            <h2 class="mb-4">My Bookings</h2>

            <div class="table-responsive">
                <table class="table table-bordered table-striped text-center">
                    <thead class="thead-dark">
                        <tr>
                            <th>Room</th>
                            <th>Check-in</th>
                            <th>Check-out</th>
                            <th>Status</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                            <tr>
                                <td><?= $row['room_id']; ?></td>
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

<?php include __DIR__ . "/includes/footer.php"; ?>