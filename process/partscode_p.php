<?php
include 'conn.php';

$method = $_POST['method'];

if ($method == 'fetch_section_list') {
    $query = "SELECT section FROM location GROUP BY section ORDER BY section ASC";
    $stmt = $conn->prepare($query);
    $stmt->execute();
    if ($stmt->rowCount() > 0) {
        echo '<option value="">Select Section</option>';
        foreach ($stmt->fetchAll() as $row) {
            echo '<option>' . htmlspecialchars($row['section']) . '</option>';
        }
    } else {
        echo '<option>Section</option>';
    }
}

if ($method == 'fetch_location_list') {
    $section = $_POST['section']; 

   
    if (!empty($section)) {
        $query = "SELECT location FROM location WHERE section = :section GROUP BY location ORDER BY location ASC";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':section', $section);
    } else {
        $query = "SELECT location FROM location GROUP BY location ORDER BY location ASC";
        $stmt = $conn->prepare($query);
    }

    $stmt->execute();
    if ($stmt->rowCount() > 0) {
        echo '<option value="">Select Line</option>';
        foreach ($stmt->fetchAll() as $row) {
            echo '<option>' . htmlspecialchars($row['location']) . '</option>';
        }
    } else {
        echo '<option>Select Location</option>';
    }
}
?>
