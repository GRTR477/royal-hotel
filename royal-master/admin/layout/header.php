<!-- HEADER -->
<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<header class="nxl-header">
    <div>
        <h2>Dashboard</h2>
        <p>Overview of hotel system</p>
    </div>

    <div class="header-right">
        <i class="fas fa-bell"></i>
        <b><?= $_SESSION['admin_name'] ?? 'Admin'; ?> (Admin)</b>
    </div>
</header>