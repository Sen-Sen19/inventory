<?php
require 'conn.php'; // Include your database connection script

try {
    $partCode = $_POST['partCode'] ?? '';

    if (empty($partCode)) {
        echo json_encode(['exists' => false, 'error' => 'Part code is required.']);
        exit;
    }

    // Prepare and execute the query to check if the part code exists
    $query = $pdo->prepare("SELECT COUNT(*) FROM manual_inventory WHERE partscode = :partCode");
    $query->bindParam(':partCode', $partCode, PDO::PARAM_STR);
    $query->execute();
    $count = $query->fetchColumn();

    echo json_encode(['exists' => $count > 0]);
} catch (PDOException $e) {
    // Handle any database errors
    echo json_encode(['exists' => false, 'error' => 'Database error: ' . $e->getMessage()]);
}
?>
