

<?php include 'tools/navbar_initial.php'; ?>
<?php include 'tools/sidebar/manualbar.php'; ?>

<?php include 'process/conn2.php';;?>


<?php

$query = "SELECT TOP (10) * FROM [new_ekanban].[dbo].[mm_masterlist]"; 


$stmt = $pdo->prepare($query, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
$stmt->execute();

echo "<table>";
    echo "<thead><tr><th>Kanban QR Code</th><th>Station</th><th>Kanban Number</th><th>Line Number</th><th>Parts Code</th><th>Parts Name</th><th>Supplier's Name</th><th>Stock Address</th><th>Quantity</th><th>Uploader</th><th>Date Uploaded</th><th>Date Updated</th><th>Status</th></tr></thead>";
    echo "<tbody>";

if ($stmt->rowCount() > 0) {
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo "<tr>";
        echo "<td>{$row['kanban_qrcode']}</td>";
        echo "<td>{$row['station']}</td>";
        echo "<td>{$row['kanban_number']}</td>";
        echo "<td>{$row['line_number']}</td>";
        echo "<td>{$row['partscode']}</td>";
        echo "<td>{$row['partsname']}</td>";
        echo "<td>{$row['suppliers_name']}</td>";
        echo "<td>{$row['stock_address']}</td>";
        echo "<td>{$row['quantity']}</td>";
        echo "<td>{$row['uploader']}</td>";
        echo "<td>{$row['date_uploaded']}</td>";
        echo "<td>{$row['date_updated']}</td>";
        echo "<td>{$row['status']}</td>";
        echo "</tr>";
    }
} else {
    echo "<tr><td>&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;No data found.".$stmt->rowCount()."</td></tr>";
}

echo "</tbody>";
    echo "</table>";
?>












<?php include 'tools/manual_footer.php'; ?>
