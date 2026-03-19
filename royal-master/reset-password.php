<?php
$conn = mysqli_connect("localhost", "root", "", "royal");

if (!isset($_GET['token'])) {
    die("Invalid request");
}

$token = $_GET['token'];

$check = mysqli_query($conn, "SELECT id FROM user WHERE reset_token='$token'");

if (mysqli_num_rows($check) != 1) {
    die("Invalid or expired token");
}

$msg = "";

if (isset($_POST['reset'])) {

    $pass = $_POST['password'];
    $cpass = $_POST['confirm_password'];

    if ($pass != $cpass) {
        $msg = "Passwords do not match";
    } else {

        $hash = password_hash($pass, PASSWORD_DEFAULT);

        mysqli_query($conn, "
            UPDATE user
            SET password='$hash', reset_token=NULL 
            WHERE reset_token='$token'
        ");

        header("Location: login.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Reset Password</title>
</head>
<body>

<h2>Reset Password</h2>

<?php if($msg) echo "<p style='color:red'>$msg</p>"; ?>

<form method="post">
    <input type="password" name="password" placeholder="New Password" required><br><br>
    <input type="password" name="confirm_password" placeholder="Confirm Password" required><br><br>
    <button type="submit" name="reset">Reset Password</button>
</form>

</body>
</html>
