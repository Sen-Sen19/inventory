<?php
// Include the database connection file
include 'conn.php';

// Number of records per page
$records_per_page = 50;

// Get the current page number from the URL, default to page 1 if not set
$current_page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
if ($current_page <= 0) {
    $current_page = 1;
}

// Calculate the starting record
$start_from = ($current_page - 1) * $records_per_page;

try {
    // Prepare SQL query to select data from the manual_inventory table with limit and offset
    $sql = "SELECT * FROM manual_inventory LIMIT :start_from, :records_per_page";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':start_from', $start_from, PDO::PARAM_INT);
    $stmt->bindParam(':records_per_page', $records_per_page, PDO::PARAM_INT);

    // Execute query
    $stmt->execute();

    // Check if any rows were returned
    if ($stmt->rowCount() > 0) {
        // Output data of each row
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
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
        echo "<tr><td colspan='7'>No results found</td></tr>";
    }

  
    $total_records_sql = "SELECT COUNT(*) FROM manual_inventory";
    $total_records_stmt = $conn->query($total_records_sql);
    $total_records = $total_records_stmt->fetchColumn();

    $total_pages = ceil($total_records / $records_per_page);

   
} catch (PDOException $e) {
  
    echo "Error: " . $e->getMessage();
}

?>
