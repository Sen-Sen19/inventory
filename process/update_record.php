<?php
// Include your database connection file
include 'conn.php';

// Retrieve the data sent via POST request
$data = json_decode(file_get_contents("php://input"), true);

// Extract data
$location = $data['location'];
$partCode = $data['partCode'];
$quantity = $data['quantity'];
$ip_address = $_SERVER['REMOTE_ADDR']; // Capture client's IP address
$pc_name = gethostbyaddr($_SERVER['REMOTE_ADDR']); // Get client's host name

try {
    // Prepare SQL statement to update verified quantity
    $sql = "UPDATE manual_inventory SET verified_qty = :quantity, scan_date_time = NOW(), ip_address = :ip_address, pc_name = :pc_name WHERE partscode = :partCode AND location = :location";
    $stmt = $conn->prepare($sql);
    
    // Bind parameters
    $stmt->bindParam(':quantity', $quantity);
    $stmt->bindParam(':ip_address', $ip_address);
    $stmt->bindParam(':pc_name', $pc_name);
    $stmt->bindParam(':partCode', $partCode);
    $stmt->bindParam(':location', $location);

    // Execute the statement
    if ($stmt->execute()) {
        // Check if any rows were affected
        if ($stmt->rowCount() > 0) {
            // If update is successful and rows were affected, return success message
            $response = array("status" => "success", "message" => "Quantity updated successfully");
            echo json_encode($response);
        } else {
            // If no rows were affected (probably because no matching row found), return error message
            $response = array("status" => "error", "message" => "No rows updated. Perhaps the record with specified location and partscode does not exist.");
            echo json_encode($response);
        }
    } else {
        // If execute() fails, return error message
        $response = array("status" => "error", "message" => "Failed to update quantity");
        echo json_encode($response);
    }
} catch (PDOException $e) {
    // If any database error occurs, return error message
    $response = array("status" => "error", "message" => "Database error: " . $e->getMessage());
    echo json_encode($response);
}
?>
