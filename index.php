<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Inventory | System</title>
  <link rel="icon" href="dist/img/logo.png" type="image/x-icon" />
  <link rel="stylesheet" href="dist/css/font.min.css">
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <style>
    .card-title {
      font-size: calc(2vw + 10px);
    }
    .btn {
      font-size: calc(1vw + 10px);
    }
    .header-center {
      display: flex;
      justify-content: center;
      align-items: center;
      height: 20vh; /* Adjust height as needed */
    }
  </style>
</head>
<body>
<section class="content">
  <div class="container-fluid">
    <div class="row">  
      <div class="col-lg-12 col-12">
        <div class="card">
          <div class="card-header header-center">
            <h2 class="card-title text-center" style="font-size: 4vw;"><b>Inventory System</b></h2>
          </div>
          <div class="card-body">
            <div class="row">
              <!-- Initial Inventory -->
              <div class="col-lg-4 col-md-4 col-sm-12 d-flex align-items-stretch">
                <div class="card card-secondary w-100">
                  <div class="card-header">
                    <h3 class="card-title col-12" style="text-align: center;"><b>INVENTORY FOR INITIAL</b></h3>
                  </div>
                  <div class="card-body d-flex justify-content-center align-items-center">
                    <a href="initial.php" class="btn btn-secondary" target="_blank">Proceed to Initial Inventory System <i class="fas fa-arrow-right"></i></a>
                  </div>
                </div>
              </div>
              <!-- Final Inventory -->
              <div class="col-lg-4 col-md-4 col-sm-12 d-flex align-items-stretch">
                <div class="card card-primary w-100">
                  <div class="card-header">
                    <h3 class="card-title col-12" style="text-align: center;"><b>INVENTORY FOR FINAL</b></h3>
                  </div>
                  <div class="card-body d-flex justify-content-center align-items-center">
                    <a href="final.php" class="btn btn-primary" target="_blank">Proceed to Final Inventory System <i class="fas fa-arrow-right"></i></a>
                  </div>
                </div>
              </div>
              <!-- Manual Inventory -->
              <div class="col-lg-4 col-md-4 col-sm-12 d-flex align-items-stretch">
                <div class="card card-success w-100">
                  <div class="card-header">
                    <h3 class="card-title col-12" style="text-align: center;"><b>INVENTORY FOR MANUAL</b></h3>
                  </div>
                  <div class="card-body d-flex justify-content-center align-items-center">
                    <a href="parts.php" class="btn btn-success" target="_blank">Proceed to Manual Inventory System <i class="fas fa-arrow-right"></i></a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
</body>
</html>
