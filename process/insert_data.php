<?php
// Include the database connection file
include 'conn.php';

// Retrieve data from the AJAX request
$partCode = $_POST['partCode'];
$partName = $_POST['partName'];
$newQuantity = $_POST['newQuantity'];
$inventoryType = $_POST['inventoryType'];
$section = $_POST['section'];
$location = $_POST['location'];
$pcname = $_POST['pcname'];
$ip = $_POST['ip'];

// Get current date and time
$now = date('Y-m-d H:i:s');

try {
    // Start a transaction
    $conn->beginTransaction();

    // Update the database with the new data
    $sqlUpdate = "UPDATE manual_inventory 
                  SET partsname = :partName, 
                      quantity = :newQuantity, 
                      scan_date_time = :scanDateTime, 
                      section = :section, 
                      location = :location, 
                      ip_address = :ip, 
                      pc_name = :pcname, 
                      verified_qty = :verifiedQty 
                  WHERE partscode = :partCode";

    $stmtUpdate = $conn->prepare($sqlUpdate);
    $stmtUpdate->bindParam(':partCode', $partCode);
    $stmtUpdate->bindParam(':partName', $partName);
    $stmtUpdate->bindParam(':newQuantity', $newQuantity);
    $stmtUpdate->bindParam(':scanDateTime', $now);
    $stmtUpdate->bindParam(':section', $section);
    $stmtUpdate->bindParam(':location', $location);
    $stmtUpdate->bindParam(':ip', $ip);
    $stmtUpdate->bindParam(':pcname', $pcname);
    $stmtUpdate->bindParam(':verifiedQty', $newQuantity);
    $stmtUpdate->execute();


    $conn->commit();

    
    echo json_encode(array('success' => true));
} catch (PDOException $e) {
   
    $conn->rollBack();
    
    echo json_encode(array('success' => false, 'message' => 'Error updating data: ' . $e->getMessage()));
}
?>
