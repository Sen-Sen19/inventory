<?php
// Include the database connection
include 'conn.php';

// Fetch data from the manual_inventory table
$query = "SELECT partscode, partsname, scan_date_time, inventory_type, section, location, verified_qty FROM manual_inventory";
$stmt = $conn->prepare($query);
$stmt->execute();
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Display data in the table
if ($results) {
    $count = 1;
    foreach ($results as $row) {
        echo "<tr>";
        echo "<td>" . $count++ . "</td>";
        echo "<td>" . htmlspecialchars($row['partscode']) . "</td>";
        echo "<td>" . htmlspecialchars($row['partsname']) . "</td>";
        echo "<td>" . htmlspecialchars($row['scan_date_time']) . "</td>";
        echo "<td>" . htmlspecialchars($row['inventory_type']) . "</td>";
        echo "<td>" . htmlspecialchars($row['section']) . "</td>";
        echo "<td>" . htmlspecialchars($row['location']) . "</td>";
        echo "<td>" . htmlspecialchars($row['verified_qty']) . "</td>";
        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='8' class='text-center'>No data available</td></tr>";
}
?>
