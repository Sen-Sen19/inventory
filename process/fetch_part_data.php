<?php
include 'conn5.php'; // Include the MySQL connection file

// SQL Server database connection
$pdo_sql_server = new PDO('sqlsrv:Server=172.25.114.162\\SQLEXPRESS;Database=new_ekanban', 'SA', 'SystemGroup2018');

if (isset($_POST['part_code'])) {
    $part_code = $_POST['part_code'];

    // MySQL query
    $stmt_mysql = $conn->prepare("SELECT DISTINCT parts_name, quantity FROM tc_kanban_masterlist WHERE parts_code = :part_code");
    $stmt_mysql->bindParam(':part_code', $part_code);
    $stmt_mysql->execute();
    $result_mysql = $stmt_mysql->fetchAll(PDO::FETCH_ASSOC);

    // SQL Server query
    $stmt_sql_server = $pdo_sql_server->prepare("SELECT DISTINCT partsname AS parts_name, quantity FROM mm_masterlist WHERE partscode = :part_code");
    $stmt_sql_server->bindParam(':part_code', $part_code);
    $stmt_sql_server->execute();
    $result_sql_server = $stmt_sql_server->fetchAll(PDO::FETCH_ASSOC);

    // Merging results from both databases
    $merged_result = array_merge($result_mysql, $result_sql_server);

    echo json_encode($merged_result);
}
?>
    