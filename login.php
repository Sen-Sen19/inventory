<?php require 'process/login.php';?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Fiscal Year End Inventory System</title>

  <link rel="icon" href="dist/img/logo.ico" type="image/x-icon" />
 
  <link rel="stylesheet" href="dist/css/font.min.css">

  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">

  <link rel="stylesheet" href="dist/css/adminlte.min.css">
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
    <img src="dist/img/logo.png" style="height:150px;">
    <h2><b>Fiscal Year End<br>Inventory System</b></h2>
  </div>

  <div class="card">
    <div class="card-body login-card-body">
      <p class="login-box-msg"><b>Sign in to start your session</b></p>

      <form action="" method="POST" id="login_form">
        <div class="input-group mb-3">
          <input type="text" class="form-control" id="username"  name="username" placeholder="Username" autocomplete="off">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-user"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" class="form-control"  id="password" name="password" placeholder="Password" autocomplete="off">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>   

          <div class="input-group mb-3">
            <button type="submit" class="btn btn-primary btn-block" name="login_btn" value="login">Sign In</button>

          </div>
      
     
        </div>
      </form>

<script src="plugins/jquery/dist/jquery.min.js"></script>

<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>

<script src="dist/js/adminlte.min.js"></script>
</body>
</html>
