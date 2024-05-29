<?php
include 'conn5.php'; // Include the MySQL connection file

// Check if the part code and new quantity are set in the POST data
if (isset($_POST['part_code']) && isset($_POST['new_quantity'])) {
    $part_code = $_POST['part_code'];
    $new_quantity = $_POST['new_quantity'];

    try {
        // Prepare and execute the SQL query to update the quantity
        $stmt = $conn->prepare("UPDATE tc_kanban_masterlist SET quantity = :new_quantity WHERE parts_code = :part_code");
        $stmt->bindParam(':new_quantity', $new_quantity);
        $stmt->bindParam(':part_code', $part_code);
        $stmt->execute();

        // Check if the update was successful
        if ($stmt->rowCount() > 0) {
            echo "Quantity updated successfully!";
        } else {
            echo "No rows updated. Part code not found or quantity unchanged.";
        }
    } catch (PDOException $e) {
        echo "Error updating quantity: " . $e->getMessage();
    }
} else {
    echo "Part code and new quantity are required.";
}
?>
