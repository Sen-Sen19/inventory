<?php

require_once 'conn.php';

$partCode = $_POST['partCode'];
$partName = $_POST['partName'];
$newQuantity = $_POST['newQuantity'];
$inventoryType = $_POST['inventoryType'];
$section = $_POST['section'];
$location = $_POST['location'];
$pcname = $_POST['pcname'];
$ip = $_POST['ip'];
$formattedDateTime = $_POST['formattedDateTime'];

try {
    // Check if the combination of partCode and location already exists
    $sql = "SELECT * FROM manual_inventory WHERE partscode = :partscode AND location = :location";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':partscode', $partCode, PDO::PARAM_STR);
    $stmt->bindParam(':location', $location, PDO::PARAM_STR);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        // If a record with the same partCode and location exists, do not insert
        $response = array('status' => 'duplicate');
        echo json_encode($response);
    } else {
        // Insert the new record since it doesn't exist
        $sql = "INSERT INTO manual_inventory (partscode, partsname, verified_qty, scan_date_time, inventory_type, section, location, ip_address, pc_name) 
                VALUES (:partscode, :partsname, :verified_qty, :scan_date_time, :inventory_type, :section, :location, :ip_address, :pc_name)";
        
        $stmt = $conn->prepare($sql);
        $stmt->execute([
            ':partscode' => $partCode,
            ':partsname' => $partName,
            ':verified_qty' => $newQuantity,
            ':scan_date_time' => $formattedDateTime,
            ':inventory_type'=> $inventoryType,
            ':section' => $section,
            ':location' => $location,
            ':ip_address' => $ip,
            ':pc_name' => $pcname
        ]);

        if ($stmt) {
            $response = array('status' => 'success');
            echo json_encode($response);
        } else {
            $response = array('status' => 'error', 'message' => 'Error inserting data');
            echo json_encode($response);
        }
    }

} catch (PDOException $e) {
    $response = array('status' => 'error', 'message' => $e->getMessage());
    echo json_encode($response);
}

$conn = null;
?>
