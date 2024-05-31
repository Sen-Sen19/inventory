<?php
// Include the database connection file
include 'conn.php';

try {
    // Prepare SQL query to select data from the manual_inventory table
    $sql = "SELECT * FROM manual_inventory";
    
    // Execute query
    $stmt = $conn->query($sql);
    
    // Check if any rows were returned
    if ($stmt->rowCount() > 0) {
        // Output data of each row
        while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo "<tr>";
            echo "<td>" . $row['id'] . "</td>";
            echo "<td>" . $row['partscode'] . "</td>";
            echo "<td>" . $row['partsname'] . "</td>";
            echo "<td>" . $row['scan_date_time'] . "</td>";
            echo "<td>" . $row['section'] . "</td>";
            echo "<td>" . $row['location'] . "</td>";
            echo "<td>" . $row['verified_qty'] . "</td>";
           
            echo "</tr>";
        }
    } else {
        echo "0 results";
    }
} catch (PDOException $e) {
    // Handle errors
    echo "Error: " . $e->getMessage();
}
?>
