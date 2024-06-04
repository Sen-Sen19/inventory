<?php

include 'conn.php';


$partCode = $_POST['partCode'];
$partName = $_POST['partName'];
$newQuantity = $_POST['newQuantity'];
$inventoryType = $_POST['inventoryType'];
$section = $_POST['section'];
$location = $_POST['location'];
$pcname = $_POST['pcname'];
$ip = $_POST['ip'];
$formattedDateTime = $_POST['formattedDateTime'];

$sql = "INSERT INTO manual_inventory (partscode, partsname, verified_qty, scan_date_time,inventory_type, section, location, ip_address, pc_name) 
        VALUES (:partscode, :partsname, :verified_qty, :scan_date_time,:inventory_type, :section, :location, :ip_address, :pc_name)";


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
    echo "Data inserted successfully";
} else {
    echo "Error inserting data";
}
?>
