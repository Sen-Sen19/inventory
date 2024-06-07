<?php

include 'conn.php';

$method = isset($_POST["method"]) ? $_POST["method"] : '';
$search = isset($_POST["search"]) ? $_POST["search"] : '';
$records_per_page = 10;
$current_page = isset($_GET['page']) ? (int)$_GET['page'] : 1;

if ($current_page <= 0) {
    $current_page = 1;
}

$start_from = ($current_page - 1) * $records_per_page;

try {
    // If search method is triggered
    if ($method == 'Search' && !empty($search)) {
        $query = "SELECT * FROM manual_inventory WHERE partscode LIKE :search LIMIT :start_from, :records_per_page";
        $stmt = $conn->prepare($query);
        $search_param = $search . '%';
        $stmt->bindParam(':search', $search_param, PDO::PARAM_STR);
    } else {
        // Default query without search
        $query = "SELECT * FROM manual_inventory LIMIT :start_from, :records_per_page";
        $stmt = $conn->prepare($query);
    }

    $stmt->bindParam(':start_from', $start_from, PDO::PARAM_INT);
    $stmt->bindParam(':records_per_page', $records_per_page, PDO::PARAM_INT);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        $c = $start_from;
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $c++;
            echo "<tr>";
            echo "<td>" . $c . "</td>";
            echo "<td>" . $row['partscode'] . "</td>";
            echo "<td>" . $row['partsname'] . "</td>";
            echo "<td>" . $row['scan_date_time'] . "</td>";
            echo "<td>" . $row['inventory_type'] . "</td>";
            echo "<td>" . $row['section'] . "</td>";
            echo "<td>" . $row['location'] . "</td>";
            echo "<td>" . $row['verified_qty'] . "</td>";
            echo "</tr>";
        }
    } else {
        echo "<tr><td colspan='8' style='text-align:center; color:red;'>No results found</td></tr>";
    }

    // Total records for pagination
    if ($method == 'Search' && !empty($search)) {
        $total_records_sql = "SELECT COUNT(*) FROM manual_inventory WHERE partscode LIKE :search";
        $total_records_stmt = $conn->prepare($total_records_sql);
        $total_records_stmt->bindParam(':search', $search_param, PDO::PARAM_STR);
    } else {
        $total_records_sql = "SELECT COUNT(*) FROM manual_inventory";
        $total_records_stmt = $conn->query($total_records_sql);
    }

    $total_records_stmt->execute();
    $total_records = $total_records_stmt->fetchColumn();
    $total_pages = ceil($total_records / $records_per_page);

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}


// $method = isset($_POST["method"]);
// $records_per_page = 50;


// $current_page = isset($_GET['page']) ? (int) $_GET['page'] : 1;
// if ($current_page <= 0) {
//     $current_page = 1;
// }


// $start_from = ($current_page - 1) * $records_per_page;

// try {

//     $sql = "SELECT * FROM manual_inventory LIMIT :start_from, :records_per_page";
//     $stmt = $conn->prepare($sql);
//     $stmt->bindParam(':start_from', $start_from, PDO::PARAM_INT);
//     $stmt->bindParam(':records_per_page', $records_per_page, PDO::PARAM_INT);


//     $stmt->execute();


//     if ($stmt->rowCount() > 0) {

//         while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
//             echo "<tr>";
//             echo "<td>" . $row['id'] . "</td>";
//             echo "<td>" . $row['partscode'] . "</td>";
//             echo "<td>" . $row['partsname'] . "</td>";
//             echo "<td>" . $row['scan_date_time'] . "</td>";
//             echo "<td>" . $row['inventory_type'] . "</td>";
//             echo "<td>" . $row['section'] . "</td>";
//             echo "<td>" . $row['location'] . "</td>";
//             echo "<td>" . $row['verified_qty'] . "</td>";
//             echo "</tr>";
//         }
//     } else {
//         echo "<tr><td colspan='7'>No results found</td></tr>";
//     }


//     $total_records_sql = "SELECT COUNT(*) FROM manual_inventory";
//     $total_records_stmt = $conn->query($total_records_sql);
//     $total_records = $total_records_stmt->fetchColumn();

//     $total_pages = ceil($total_records / $records_per_page);


// } catch (PDOException $e) {

//     echo "Error: " . $e->getMessage();
// }

// // if ($method == 'Search') {
// //     $search = '%' . $_POST['search'] . '%';

// //     $sql = "SELECT * FROM manual_inventory 
// //             WHERE partscode LIKE :search 
// //             OR partsname LIKE :search";

// //     $stmt = $conn->prepare($sql);
// //     $stmt->bindParam(':search', $search, PDO::PARAM_STR);
// //     $stmt->execute();

// //     if ($stmt->rowCount() > 0) {
// //         while ($j = $stmt->fetch(PDO::FETCH_ASSOC)) {
// //             echo "<tr>";
// //             echo "<td>" . $j['id'] . "</td>";
// //             echo "<td>" . $j['partscode'] . "</td>";
// //             echo "<td>" . $j['partsname'] . "</td>";
// //             echo "<td>" . $j['scan_date_time'] . "</td>";
// //             echo "<td>" . $j['inventory_type'] . "</td>";
// //             echo "<td>" . $j['section'] . "</td>";
// //             echo "<td>" . $j['location'] . "</td>";
// //             echo "<td>" . $j['verified_qty'] . "</td>";
// //             echo "</tr>";
// //         }
// //     } else {
// //         echo "<tr><td colspan='8'>No results found</td></tr>"; // Correct colspan to match the number of columns
// //     }
// // }

// if ($method == 'Search') {
//     $search = $_POST['search'];
//     $c = 0;

//     $query = "SELECT * FROM manual_inventory WHERE partscode LIKE '$search%'";
//     $stmt = $conn->prepare($query);
//     $stmt->execute();
//     if ($stmt->rowCount() > 0) {
//         foreach ($stmt->fetchALL() as $j) {
//             $c++;
//             echo '<tr>';
//             echo '<td>' . $c . '</td>';
//             echo "<td>" . $j['partscode'] . "</td>";
//             echo "<td>" . $j['partsname'] . "</td>";
//             echo "<td>" . $j['scan_date_time'] . "</td>";
//             echo "<td>" . $j['inventory_type'] . "</td>";
//             echo "<td>" . $j['section'] . "</td>";
//             echo "<td>" . $j['location'] . "</td>";
//             echo "<td>" . $j['verified_qty'] . "</td>";
//             echo "</tr>";
//         }
//     } else {
//         echo '<tr>';
//         echo '<td colspan="6" style="text-align:center; color:red;">No Result !!!</td>';
//         echo '</tr>';
//     }
// }

?>