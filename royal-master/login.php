    <?php

    session_start();

    $conn = mysqli_connect("localhost", "root", "", "royal");

    if (!$conn) {

        die("connection failed");
    }

    $message = "";

    if (isset($_POST['login_btn'])) {

        $login = $_POST['login'];
        $password = $_POST['password'];






        $query = mysqli_query($conn, "SELECT * FROM user WHERE email='$login' OR phone='$login'");

        if (mysqli_num_rows($query) == 1) {

            $user = mysqli_fetch_assoc($query);

            if (password_verify($password, $user['password'])) {

                $_SESSION['user_id']   = $user['id'];
                $_SESSION['user_name'] = $user['name'];

                $_SESSION['role'] = $user['role'];

                if ($user['role'] === 'admin') {
                    $_SESSION['admin_id']   = $user['id'];
                    $_SESSION['admin_name'] = $user['name'];
                    header("Location: admin/dashboard.php");
                } else {
                    $_SESSION['user_id']   = $user['id'];
                    $_SESSION['user_name'] = $user['name'];
                    header("Location: index.php");
                }
                exit();
            } else {
                $message = "Password galat hai";
            }
        } else {
            $message = "Email ya Phone register nahi hai";
        }
    }


    include __DIR__ . "/includes/header.php";
    ?>



    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <title>Login</title>
        <style>
            body {
                font-family: Arial, sans-serif;
                background: #f2f2f2;
            }

            .login-box {
                width: 500px;
                margin: 120px auto;
                background: #fff;
                padding: 20px;
                border-radius: 5px;
                box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            }

            .login-box h2 {
                text-align: center;
                margin-bottom: 20px;
            }

            .login-box input {
                width: 100%;
                padding: 10px;
                margin: 8px 0;
                border: 1px solid #ccc;
                border-radius: 4px;
            }

            .login-box button {
                width: 100%;
                padding: 10px;
                background: #007bff;
                color: #fff;
                border: none;
                border-radius: 4px;
                cursor: pointer;
            }

            .login-box button:hover {
                background: #0056b3;
            }
        </style>
    </head>

    <body>

        <div class="login-box">
            <h2>Login</h2>

            <?php if (!empty($message)) echo "<p style='color:red;text-align:center;'>$message</p>"; ?>
            <form method="post" action="login.php">
                <input type="text" name="login" placeholder="Email or Phone Number">
                <input type="password" name="password" placeholder="Password" required>
                <button type="submit" name="login_btn">Login</button>
                <a href="forgot-password">Forgot Password?</a>/
                <a href="register">Signup</a>


            </form>

        </div>
        <?php include __DIR__ . "/includes/footer.php"; ?>
    </body>

    </html>