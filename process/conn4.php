<?php
    $servername = '172.25.112.171';
    $username = 'root';
    $pass = '';
    date_default_timezone_set('Asia/Manila');
    $server_date = date('Y-m-d H:i:s');
    $server_date_only = date('Y-m-d');
    try {
        $conn4 = new PDO ("mysql:host=$servername;dbname=tube_making",$username,$pass);
    
    }catch(PDOException $e){
        echo 'NO CONNECTION'.$e->getMessage();
    }
?>