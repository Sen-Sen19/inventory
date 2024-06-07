<?php
// Include your database connection file
include 'conn.php';

// Retrieve the data sent via POST request
$data = json_decode(file_get_contents("php://input"), true);

// Extract data
$partCode = $data['partCode'];
$partName = $data['partName'];
$quantity = $data['quantity'];

try {
    // Prepare SQL statement to update verified quantity
    $sql = "UPDATE manual_inventory SET verified_qty = :quantity WHERE partscode = :partCode AND partsname = :partName";
    $stmt = $conn->prepare($sql);
    
    // Bind parameters
    $stmt->bindParam(':quantity', $quantity);
    $stmt->bindParam(':partCode', $partCode);
    $stmt->bindParam(':partName', $partName);

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
