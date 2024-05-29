<?php
header("Content-type: text/html;charset=Shift-JIS");
    date_default_timezone_set('Asia/Manila');
$username = "FSIB";
$password = "FSIB";
$database = "172.25.116.61:1521/fsib";
$ora = oci_connect($username, $password, $database);
if (!$ora) {
    $e = oci_error();
    trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
}else{
    // echo 'success';
}