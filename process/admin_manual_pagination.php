<?php
// Include the database connection file
include 'conn.php';

// Number of records per page
$records_per_page = 10;

// Get the current page number from the URL, default to page 1 if not set
$current_page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
if ($current_page <= 0) {
    $current_page = 1;
}

// Calculate the total number of pages
$total_pages = ceil($total_records / $records_per_page);

// Display pagination links
for ($i = 1; $i <= $total_pages; $i++) {
    $active = ($i == $current_page) ? 'active' : '';
    echo "<li class='page-item $active'><a class='page-link' href='admin_manual.php?page=$i'>$i</a></li>";
}
?>
