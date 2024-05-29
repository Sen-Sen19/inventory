<?php
// Revisions (Vince)
session_start();

$method = $_POST['method'];

if ($method == 'get_client_pc_info') {
   // When Requested By AJAX Call
   $ip = $_SERVER['REMOTE_ADDR'];

   if (!isset($_SESSION['ip'])) {
      $_SESSION['ip'] = $ip;
      $_SESSION['pc_name'] = gethostbyaddr($_SERVER['REMOTE_ADDR']);
   } else if ($_SESSION['ip'] != $ip) {
      $_SESSION['ip'] = $ip;
      $_SESSION['pc_name'] = gethostbyaddr($_SERVER['REMOTE_ADDR']);
   } else if (!isset($_SESSION['pc_name'])) {
      $_SESSION['pc_name'] = gethostbyaddr($_SERVER['REMOTE_ADDR']);
   }
   echo 'IP: ' . $_SESSION['ip'] . ' | HOSTNAME: ' . $_SESSION['pc_name'];
} else {
   // For Regular Execution
   $ip = $_SERVER['REMOTE_ADDR'];

   if (!isset($_SESSION['ip'])) {
      $_SESSION['ip'] = $ip;
      $_SESSION['pc_name'] = gethostbyaddr($_SERVER['REMOTE_ADDR']);
   } else if ($_SESSION['ip'] != $ip) {
      $_SESSION['ip'] = $ip;
      $_SESSION['pc_name'] = gethostbyaddr($_SERVER['REMOTE_ADDR']);
   } else if (!isset($_SESSION['pc_name'])) {
      $_SESSION['pc_name'] = gethostbyaddr($_SERVER['REMOTE_ADDR']);
   }
}
