<?php

require_once 'conn.php';

// Assuming partCode and location are sent via POST from your AJAX request
$partCode = $_POST['partCode'];
$location = $_POST['location'];

try {
    // Check if the combination of partCode and location already exists
    $sql = "SELECT * FROM manual_inventory WHERE partscode = :partscode AND location = :location";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':partscode', $partCode, PDO::PARAM_STR);
    $stmt->bindParam(':location', $location, PDO::PARAM_STR);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        // If a record with the same partCode and location exists, return 'duplicate'
        $response = array('status' => 'duplicate');
    } else {
        // If no record found, return 'not_duplicate'
        $response = array('status' => 'not_duplicate');
    }

    // Send JSON response back to the client-side AJAX request
    echo json_encode($response);

} catch (PDOException $e) {
    // Handle database errors if any
    $response = array('status' => 'error', 'message' => $e->getMessage());
    echo json_encode($response);
}

$conn = null;
?>
