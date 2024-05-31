<?php
// Include your database connection file
include 'conn.php';

// Retrieve data from AJAX request
$partCode = $_POST['partCode'];
$partName = $_POST['partName'];
$newQuantity = $_POST['newQuantity'];
$inventoryType = $_POST['inventoryType'];
$section = $_POST['section'];
$location = $_POST['location'];
$pcname = $_POST['pcname'];
$ip = $_POST['ip'];
$formattedDateTime = $_POST['formattedDateTime'];

// Prepare SQL statement
$sql = "INSERT INTO manual_inventory (partscode, partsname, verified_qty, scan_date_time, section, location, ip_address, pc_name) 
        VALUES (:partscode, :partsname, :verified_qty, :scan_date_time, :section, :location, :ip_address, :pc_name)";

// Prepare and execute the statement
$stmt = $conn->prepare($sql);
$stmt->execute([
    ':partscode' => $partCode,
    ':partsname' => $partName,
    ':verified_qty' => $newQuantity,
    ':scan_date_time' => $formattedDateTime,
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
