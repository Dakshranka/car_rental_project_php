<?php
include 'connection.php';

// Booking stats
$booking_count = mysqli_fetch_row(mysqli_query($con, "SELECT COUNT(*) FROM booking"))[0];
$revenue = mysqli_fetch_row(mysqli_query($con, "SELECT SUM(PRICE) FROM payment"))[0];
$popular_cars = mysqli_query($con, "SELECT CAR_ID, COUNT(*) as cnt FROM booking GROUP BY CAR_ID ORDER BY cnt DESC LIMIT 5");

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Analytics Dashboard</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <h2>Admin Analytics Dashboard</h2>
    <p>Total Bookings: <?php echo $booking_count; ?></p>
    <p>Total Revenue: ₹<?php echo $revenue ? $revenue : 0; ?></p>
    <h3>Top 5 Popular Cars (by bookings)</h3>
    <table border="1">
        <tr>
            <th>Car ID</th>
            <th>Bookings</th>
        </tr>
        <?php while ($row = mysqli_fetch_assoc($popular_cars)) { ?>
        <tr>
            <td><?php echo $row['CAR_ID']; ?></td>
            <td><?php echo $row['cnt']; ?></td>
        </tr>
        <?php } ?>
    </table>
</body>
</html>
