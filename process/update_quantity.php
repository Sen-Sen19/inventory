<?php
// include 'conn5.php'; // Include the MySQL connection file


// // Check if the part code, part name, and new quantity are set in the POST data
// if (isset($_POST['part_code']) && isset($_POST['part_name']) && isset($_POST['new_quantity'])) {
//     $part_code = $_POST['part_code'];
//     $part_name = $_POST['part_name'];
//     $new_quantity = $_POST['new_quantity'];

//     try {
//         // Database connection should be established before this point
//         // Assuming $conn is the database connection

//         // Prepare and execute the SQL query to update the quantity of the first matching row
//         $stmt = $conn->prepare("
//             UPDATE tc_kanban_masterlist 
//             SET quantity = :new_quantity 
//             WHERE parts_code = :part_code 
//               AND parts_name = :part_name 
//               AND id = (
//                   SELECT id 
//                   FROM (
//                       SELECT id 
//                       FROM tc_kanban_masterlist 
//                       WHERE parts_code = :part_code 
//                         AND parts_name = :part_name 
//                       LIMIT 1
//                   ) AS subquery
//               )
//         ");
//         $stmt->bindParam(':new_quantity', $new_quantity);
//         $stmt->bindParam(':part_code', $part_code);
//         $stmt->bindParam(':part_name', $part_name);
//         $stmt->execute();

//         // Check if the update was successful
//         if ($stmt->rowCount() > 0) {
//             echo "success";
//         } else {
//             echo "No rows updated. Part code not found or quantity unchanged.";
//         }
//     } catch (PDOException $e) {
//         echo "Error updating quantity: " . $e->getMessage();
//     }
// } else {
//     echo "Part code, part name, and new quantity are required.";
// }
?>
