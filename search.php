<?php
include 'connection.php';

// Handle search
$search = isset($_GET['search']) ? $_GET['search'] : '';
$sql = "SELECT * FROM cars WHERE CAR_NAME LIKE '%$search%' OR FUEL_TYPE LIKE '%$search%'";
$result = mysqli_query($con, $sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Search Cars</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <h2>Search Cars</h2>
    <form method="GET">
        <input type="text" name="search" placeholder="Search by name or fuel type" value="<?php echo htmlspecialchars($search); ?>">
        <button type="submit">Search</button>
    </form>
    <table border="1">
        <tr>
            <th>Car ID</th>
            <th>Name</th>
            <th>Fuel Type</th>
            <th>Price</th>
            <th>Availability</th>
        </tr>
        <?php while ($row = mysqli_fetch_assoc($result)) { ?>
        <tr>
            <td><?php echo $row['CAR_ID']; ?></td>
            <td><?php echo $row['CAR_NAME']; ?></td>
            <td><?php echo $row['FUEL_TYPE']; ?></td>
            <td><?php echo $row['PRICE']; ?></td>
            <td><?php echo $row['AVAILABILITY']; ?></td>
        </tr>
        <?php } ?>
    </table>
</body>
</html>
