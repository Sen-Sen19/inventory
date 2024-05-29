<?php
 include 'conn.php';
 session_start();
 if (isset($_POST['login_btn'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    if (empty($username)) {
        echo 'Please Enter Username';
    }else if(empty($password)){
        echo 'Please Enter Password';
    }

    else{

        $check = "SELECT id FROM user_accounts WHERE BINARY username = '$username' AND BINARY password = '$password'";
        $stmt = $conn->prepare($check);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            
            foreach($stmt->fetchALL() as $x){
                 $_SESSION['username'] = $username;        
                header('location: admin.php'); 
            }
           
        }else{
            echo '<labe style="color:red;">Wrong Username Or Password</labe>';
        }
    }
 }
 if (isset($_POST['Logout'])) {
    session_unset();
    session_destroy();
    header('location: login.php');
 }


?>