<?php
include 'tools/navbar_manual.php';
include 'tools/sidebar/manualbar.php';
include 'process/conn2.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Barcode Scanning</title>
  <!-- Include jQuery -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<style>
  .form-container {
    background-color: white;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    overflow: hidden;
    width: 80%;
    max-width: 100%;
    margin: 50px 100px 50px 15%;
  }

  .form-header {
    background-color: #17a2b8;
    padding: 8px;
    text-align: center;
    color: white;
    font-size: 24px;
  }

  .card-body {
    padding: 20px;
  }

  .wide-button {
    width: 50%;
    padding: 10px 0;
    font-size: 16px;
  }
</style>

<body>

  <div class="form-container">
    <div class="form-header"></div>
    <form>
      <div class="card-body">
        <div class="row">
          <div class="col-6">
            <a href="#" class="btn btn-primary wide-button" data-toggle="modal" data-target="#scanning_manual">Manual
              Input</a>
          </div>
        </div>
      </div>
     
    </form>
  </div>

</body>

</html>

<?php
include 'tools/manual_footer.php';
include 'tools/javascript/manual_script.php';
?>