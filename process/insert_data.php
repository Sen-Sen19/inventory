<?php
// Include the database connection file
include 'conn.php';

// Retrieve data from the AJAX request
// Retrieve data from the AJAX request
$partCode = $_POST['partCode'];
$partName = $_POST['partName'];
$newQuantity = $_POST['newQuantity'];
$inventoryType = $_POST['inventoryType']; // Retrieve inventory type
$section = $_POST['section'];
$location = $_POST['location'];
$pcname = $_POST['pcname'];
$ip = $_POST['ip'];

// Get current date and time
$now = date('Y-m-d H:i:s');

try {
    // Start a transaction
    $conn->beginTransaction();

    // Prepare SQL query
    $sql = "INSERT INTO manual_inventory (partscode, partsname, quantity, scan_date_time, section, location, ip_address, pc_name, verified_qty, inventory_type) 
            VALUES (:partCode, :partName, :newQuantity, :scanDateTime, :section,:inventoryType, :location, :ip, :pcname, :verifiedQty, :inventoryType)";
    
    // Prepare statement
    $stmt = $conn->prepare($sql);
    
    // Bind parameters
    $stmt->bindParam(':partCode', $partCode);
    $stmt->bindParam(':partName', $partName);
    $stmt->bindParam(':newQuantity', $newQuantity);
    $stmt->bindParam(':scanDateTime', $now);
    $stmt->bindParam(':section', $section);
    $stmt->bindParam(':inventoryType', $inventoryType); // Bind inventory type
    $stmt->bindParam(':location', $location);
    $stmt->bindParam(':ip', $ip);
    $stmt->bindParam(':pcname', $pcname);
    $stmt->bindParam(':verifiedQty', $newQuantity);
 
    
    // Execute statement
    $stmt->execute();

    // Commit transaction
    $conn->commit();

    // Return success response
    echo json_encode(array('success' => true));
} catch (PDOException $e) {
    // Roll back transaction and return error response
    $conn->rollBack();
    echo json_encode(array('success' => false, 'message' => 'Error updating data: ' . $e->getMessage()));
}

?>
