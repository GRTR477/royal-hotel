<?php
session_start();
$conn = mysqli_connect("localhost", "root", "", "royal");

$msg = "";

if (isset($_POST['submit'])) {

    $email = $_POST['email'];

    $check = mysqli_query($conn, "SELECT id FROM user WHERE email='$email'");

    if (mysqli_num_rows($check) == 1) {


        $token = bin2hex(random_bytes(32));


        mysqli_query($conn, "UPDATE user SET reset_token='$token' WHERE email='$email'");


        $link = "http://localhost/royal/reset-password.php?token=$token";

        echo "<br><br>Reset Link:<br>";
        echo $link;
        



        $subject = "Reset Your Password";
        $message = "Click this link to reset password:\n$link";
        $headers = "From: noreply@royalhotel.com";

        mail($email, $subject, $message, $headers);
    }


    $msg = "If email exists, reset link has been sent.";
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Forgot Password</title>
</head>

<body>

    <h2>Forgot Password</h2>

    <?php if ($msg) echo "<p>$msg</p>"; ?>

    <form method="post">
        <input type="email" name="email" placeholder="Enter registered email" required>
        <br><br>
        <button type="submit" name="submit">Send Reset Link</button>
    </form>

</body>

</html>