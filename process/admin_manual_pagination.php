<?php

include 'conn.php';


$records_per_page = 10;


$current_page = isset($_GET['page']) ? (int) $_GET['page'] : 1;
if ($current_page <= 0) {
    $current_page = 1;
}


$total_pages = ceil($total_records / $records_per_page);


for ($i = 1; $i <= $total_pages; $i++) {
    $active = ($i == $current_page) ? 'active' : '';
    echo "<li class='page-item $active'><a class='page-link' href='admin_manual.php?page=$i'>$i</a></li>";
}
?>