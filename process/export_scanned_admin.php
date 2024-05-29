<?php
include 'conn.php';
ini_set("memory_limit", "-1");
 $line_no = $_GET['line_no'];
 $c = 0;

$filename = "Scanned LIST-".$server_date_time.".xls";
header("Content-Type: application/vnd.ms-excel");
header('Content-Type: text/csv; charset=utf-8');  
header("Content-Disposition: ; filename=\"$filename\"");
echo'
<html lang="en">
<body>
<table border="1">
<thead>
            <th>#</td>
            <th>Inventory Tag No</th>
            <th>Location Code</th>
            <th>Part Code</th>
            <th>Part Name</th>
            <th>Physical Count</th>
            <th>Verified QTY</th>
            <th>Length</th>
            <th>Kanban Line Number</th> 
            <th>Date Scanned</th> 
            <th>Kanban Type</th> 
            <th>Section</th> 
            <th>IP Address</th>
            <th>PC Name</th>
</thead>
';
$query = "SELECT * FROM mm_inventory";
    $stmt = $conn->prepare($query);
    $stmt->execute();
    if ($stmt->rowCount() > 0) {
        foreach($stmt->fetchALL() as $j){
            $c++;
        echo '<tr>';
            echo '<td>'.$c.'</td>';
            echo '<td>'.$j['id'].'</td>';
            echo '<td>'.strtoupper($j['location']).'</td>';
            echo '<td>'.$j['partscode'].'</td>';
            echo '<td>'.$j['partsname'].'</td>';
            echo '<td>'.$j['quantity'].'</td>';
            echo '<td>'.$j['verified_qty'].'</td>';
            echo '<td>'.$j['length'].'</td>';
            echo '<td>'.$j['kanban_line_no'].'</td>';
            echo '<td>'.$j['scan_date_time'].'</td>';
            echo '<td>'.$j['kanban_type'].'</td>';
            echo '<td>'.strtoupper($j['line_number']).'</td>';
            echo '<td>'.$j['ip_address'].'</td>';
            echo '<td>'.$j['pc_name'].'</td>';
        echo '</tr>';
        }
    }else{
        echo '<tr>';
            echo '<td colspan="12" style="text-align:center; color:red;">No Result !!!</td>';
        echo '</tr>';
    }
?>