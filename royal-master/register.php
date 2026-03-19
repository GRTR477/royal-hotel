<?php

$conn = mysqli_connect("localhost", "root", "", "royal");

if (!$conn) {
    die("Database connection failed");
}

$message = "";

if (isset($_POST['signup'])) {

    $name     = $_POST['name'];
    $email    = $_POST['email'];
    $phone    = $_POST['phone'];
    $password = $_POST['password'];
    $confirm  = $_POST['confirm'];

    $hash_password = password_hash($password, PASSWORD_DEFAULT);
    if ($password !== $confirm) {
        $message = " Password  does not match";
    } elseif (strlen($password) < 6) {
        $message = " enter minimum 6 characters";
    } else {

        $check = mysqli_query($conn, "SELECT * FROM user WHERE email='$email' OR phone='$phone'");

        if (mysqli_num_rows($check) > 0) {
            $message = " Email already exist karta hai";
        } else {




            $query = "INSERT INTO user (name, email, phone, password, role) VALUES ('$name', '$email', '$phone', '$hash_password', 'user')";

            if (mysqli_query($conn, $query)) {
                $message = "Signup successfully ho gaya";
            } else {
                $message = " Signup nahi hua";
            }
        }
    }
}

include __DIR__ . "/includes/header.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Signup Form</title>
    
        <style>
    body {
    font-family: Arial, sans-serif;
    background: #f2f2f2;
    }

    .signup-box {
    width: 500px;
    margin: 80px auto;
    background: #fff;
    padding: 20px;
    margin-top: 120px;
    border-radius: 5px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    .signup-box h2 {
    text-align: center;
    margin-bottom: 10px;
    }

    .signup-box input {
    width: 100%;
    padding: 10px;
    margin: 8px 0;
    border: 1px solid #ccc;
    border-radius: 4px;
    }

    .signup-box button {
    width: 100%;
    padding: 10px;
    background: #28a745;
    color: #fff;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    }

    .signup-box button:hover {
    background: #218838;
    }
    </style>
</head>

<body>

    <div class="signup-box">
        <h2>Signup</h2>
        <form method="post" action="">
            <input type="text" name="name" placeholder="Enter Name" required>

            <input type="email" name="email" placeholder="Enter Email" required>

            <input type="text" name="phone" placeholder="Enter Phone Number" required>

            <input type="password" name="password" placeholder="Enter Password" required>

            <input type="password" name="confirm" placeholder="Confirm Password" required>

            <button type="submit" name="signup">Signup</button>
        </form>
    </div>
    <?php include __DIR__ . "/includes/footer.php"; ?>
</body>

</html>