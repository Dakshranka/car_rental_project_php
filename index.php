<?php

session_start();
include './configs/database.php';

if (isset($_POST['submit'])) {
    $logAdmin = isset($_POST['log_admin']); // Check if login as admin checkbox is checked
    $error = false;
    $error_email = '';
    $error_password = '';

    // Check if email is set in the $_POST array
    $email = isset($_POST['email']) ? htmlspecialchars($_POST['email']) : '';

    $password = htmlspecialchars($_POST['password']);

    if (empty($email)) {
        $error = true;
        $error_email = 'Email is required';
    }

    if (!$error) {
        if (!empty($email) && !empty($password)) {
            if ($logAdmin) {
                // Login as Admin
                $sql = "SELECT * FROM admins WHERE email='$email' AND password='$password'";
                $result = mysqli_query($conn, $sql);
                if (mysqli_num_rows($result) === 1) {
                    $row = mysqli_fetch_assoc($result);
                    if ($row['email'] === $email && $row['password'] === $password) {
                        $_SESSION['admin_logged'] = true;
                        $_SESSION['admin_id'] = $row['id'];
                        $_SESSION['admin_email'] = $row['email'];
                        header("location: cardetails.php");
                        exit();
                    } else {
                        $error = true;
                        $error_password = 'Incorrect password';
                    }
                } else {
                    $error = true;
                    $error_email = 'Email not recognized';
                }
            } else {
                // Login as customer
            }
        } else {
            $error = true;
            $error_email = 'Email and password are required';
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP Car rental Project</title>
    <link rel="stylesheet" href="./assets/css/login.css">
</head>

<body>

    <h1>Login To Your Dashboard</h1>
    <form method="post">
        <?php if (isset($error)) { ?>
            <div class="error"><?= $error_email ?></div>
            <div class="error"><?= $error_password ?></div>
        <?php } ?>
        <div class="row">
            <label for="email">Email</label>
            <input type="email" name="email" autocomplete="off" placeholder="email@example.com" value="<?= isset($_POST['email']) ? htmlspecialchars($_POST['email']) : '' ?>">
        </div>
        <div class="row">
            <label for="password">Password</label>
            <input type="password" name="password">
        </div>
        <div style="display: flex; color:#8086a9;">
            <input type="checkbox" name="log_admin">
            <label for="">Log as admin</label>
        </div>
        <div style="display: flex; color:#8086a9;">
            <div class="links">
                <a href="/views/customer/signin" class="link">Create an account</a>
                <a href="/views/admin/registration" class="link">Admin account</a>
            </div>
        </div>
        <button type="submit" name="submit">Login</button>
    </form>

</body>

</html>
