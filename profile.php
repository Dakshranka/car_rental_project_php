<?php
session_start();
include 'connection.php';

if (!isset($_SESSION['user_email'])) {
    header('Location: index.php');
    exit();
}

$email = $_SESSION['user_email'];

// Fetch user info
$user_query = "SELECT * FROM admins WHERE EMAIL='$email'";
$user_result = mysqli_query($con, $user_query);
$user = mysqli_fetch_assoc($user_result);

// Fetch booking history
$booking_query = "SELECT * FROM booking WHERE EMAIL='$email' ORDER BY BOOK_DATE DESC";
$booking_result = mysqli_query($con, $booking_query);

// Handle profile update
if (isset($_POST['update'])) {
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $phone = $_POST['phone'];
    $gender = $_POST['gender'];
    $lic_num = $_POST['lic_num'];
    $update_query = "UPDATE admins SET FNAME='$fname', LNAME='$lname', PHONE_NUMBER='$phone', GENDER='$gender', LIC_NUM='$lic_num' WHERE EMAIL='$email'";
    mysqli_query($con, $update_query);
    header('Location: profile.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>User Profile</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <h2>User Profile</h2>
    <form method="POST">
        <label>First Name:</label>
        <input type="text" name="fname" value="<?php echo $user['FNAME']; ?>" required><br>
        <label>Last Name:</label>
        <input type="text" name="lname" value="<?php echo $user['LNAME']; ?>" required><br>
        <label>Phone Number:</label>
        <input type="text" name="phone" value="<?php echo $user['PHONE_NUMBER']; ?>" required><br>
        <label>Gender:</label>
        <input type="text" name="gender" value="<?php echo $user['GENDER']; ?>" required><br>
        <label>License Number:</label>
        <input type="text" name="lic_num" value="<?php echo $user['LIC_NUM']; ?>" required><br>
        <button type="submit" name="update">Update Profile</button>
    </form>
    <h3>Booking History</h3>
    <table border="1">
        <tr>
            <th>Booking ID</th>
            <th>Car ID</th>
            <th>Place</th>
            <th>Date</th>
            <th>Duration</th>
            <th>Destination</th>
            <th>Status</th>
        </tr>
        <?php while ($row = mysqli_fetch_assoc($booking_result)) { ?>
        <tr>
            <td><?php echo $row['BOOK_ID']; ?></td>
            <td><?php echo $row['CAR_ID']; ?></td>
            <td><?php echo $row['BOOK_PLACE']; ?></td>
            <td><?php echo $row['BOOK_DATE']; ?></td>
            <td><?php echo $row['DURATION']; ?></td>
            <td><?php echo $row['DESTINATION']; ?></td>
            <td><?php echo $row['BOOK_STATUS']; ?></td>
        </tr>
        <?php } ?>
    </table>
</body>
</html>
