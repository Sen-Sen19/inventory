<?php
// Include your database connection file
include 'conn.php';

// Retrieve the data sent via POST request
$data = json_decode(file_get_contents("php://input"), true);

// Extract data
$partCode = $data['partCode'];
$partName = $data['partName'];
$quantity = $data['quantity'];
$ip_address = $_SERVER['REMOTE_ADDR']; // Capture client's IP address
$pc_name = gethostbyaddr($_SERVER['REMOTE_ADDR']); // Get client's host name

try {
    // Prepare SQL statement to update verified quantity
    $sql = "UPDATE manual_inventory SET verified_qty = :quantity, scan_date_time = NOW(), ip_address = :ip_address, pc_name = :pc_name WHERE partscode = :partCode AND partsname = :partName";
    $stmt = $conn->prepare($sql);
    
    // Bind parameters
    $stmt->bindParam(':quantity', $quantity);
    $stmt->bindParam(':partCode', $partCode);
    $stmt->bindParam(':partName', $partName);
    $stmt->bindParam(':ip_address', $ip_address);
    $stmt->bindParam(':pc_name', $pc_name);

    // Execute the statement
    if ($stmt->execute()) {
        // If update is successful, return success message
        $response = array("status" => "success", "message" => "Quantity updated successfully");
        echo json_encode($response);
    } else {
        // If update fails, return error message
        $response = array("status" => "error", "message" => "Failed to update quantity");
        echo json_encode($response);
    }
} catch (PDOException $e) {
    // If any database error occurs, return error message
    $response = array("status" => "error", "message" => "Database error: " . $e->getMessage());
    echo json_encode($response);
}
?>
