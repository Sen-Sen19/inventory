<?php
include 'conn.php';
ini_set("memory_limit", "-1");
$line_no = $_GET['line_no'];
$c = 0;

$filename = "Scanned LIST-" . $server_date_time . ".xls";
header("Content-Type: application/vnd.ms-excel");
header('Content-Type: text/csv; charset=utf-8');
header("Content-Disposition: ; filename=\"$filename\"");
echo '
<html lang="en">
<body>
<table border="1">
<thead>
            <th>ID</td>
           
           
            <th>Part Code</th>
            <th>Part Name</th>
            <th>Scanned Date</th>
           
            <th>Section</th> 
            <th>Location</th> 
            <th>IP Address</th>
            <th>PC Name</th>
            <th>Verified Quantity</th> 
</thead>
';
$query = "SELECT * FROM manual_inventory";
$stmt = $conn->prepare($query);
$stmt->execute();
if ($stmt->rowCount() > 0) {
    foreach ($stmt->fetchALL() as $j) {
        $c++;
        echo '<tr>';
        echo '<td>' . $c . '</td>';
        echo '<td>' . $j['partscode'] . '</td>';
        echo '<td>' . $j['partsname'] . '</td>';
        echo '<td>' . $j['scan_date_time'] . '</td>';
        echo '<td>' . $j['section'] . '</td>';
        echo '<td>' . $j['location'] . '</td>';
        echo '<td>' . $j['ip_address'] . '</td>';
        echo '<td>' . $j['pc_name'] . '</td>';
        echo '<td>' . $j['verified_qty'] . '</td>';


        echo '</tr>';
    }
} else {
    echo '<tr>';
    echo '<td colspan="12" style="text-align:center; color:red;">No Result !!!</td>';
    echo '</tr>';
}
?>