<?php
//SESSION
include 'process/session.php';
if ($role = 'admin') {
  // DO NOTHING
} else {
  session_unset();
  session_destroy();
  header('location: ../../index.php');
}
?>



<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Inventory System</title>
  <link rel="icon" href="dist/img/logo.png" type="image/x-icon" />
  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="dist/css/font.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <style>


    .loader {
      border: 16px solid #f3f3f3;
      border-radius: 50%;
      border-top: 16px solid #536A6D;
      width: 50px;
      height: 50px;
      -webkit-animation: spin 2s linear infinite;
      animation: spin 2s linear infinite;
    }

    @keyframes spin {
      0% {
        transform: rotate(0deg);
      }

      100% {
        transform: rotate(1080deg);
      }
    }


    .pagination-section {
  margin-top: 20px;
}

.pagination {
  display: flex;
  justify-content: center;
}

.pagination .page-link {
  color: #007bff;
  background-color: #fff;
  border: 1px solid #dee2e6;
  margin: 0 3px;
  padding: 3px 8px;
  border-radius: 4px;
}

.pagination .page-link:hover {
  z-index: 2;
  color: #0056b3;
  background-color: #e9ecef;
  border-color: #dee2e6;
}

.pagination .page-item.active .page-link {
  z-index: 3;
  color: #fff;
  background-color: #007bff;
  border-color: #007bff;
}

.pagination .page-item.disabled .page-link {
  color: #6c757d;
  pointer-events: none;
  cursor: auto;
  background-color: #fff;
  border-color: #dee2e6;
}
    
    
  </style>
</head>

<body class="hold-transition sidebar-mini">
  <div class="wrapper">
    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
      <!-- Left navbar links -->
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
      </ul>

      <!-- Right navbar links -->
      <ul class="navbar-nav ml-auto">
        <li class="nav-item">
          <a class="nav-link" data-widget="fullscreen" href="#" role="button">
            <i class="fas fa-expand-arrows-alt"></i>
          </a>
        </li>
      </ul>
    </nav>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
      <!-- Brand Logo -->
      <a href="index3.html" class="brand-link">
        <img src="dist/img/logo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">Inventory System</span>
      </a>

      <!-- Sidebar -->
      <div class="sidebar">
        <!-- Sidebar user (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
          <div class="image">
            <img src="dist/img/user.png" class="img-circle elevation-2" alt="User Image">
          </div>
          <div class="info">
            <a href="#" class="d-block"><?= $name; ?></a>
          </div>
        </div>
        <!-- Sidebar Menu -->
        <nav class="mt-2">
          <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">




            <li class="nav-item">
              <?php if ($_SERVER['REQUEST_URI'] == "/inventory/admin.php") { ?>
                <a href="admin.php" class="nav-link active">
                <?php } else { ?>
                  <a href="admin.php" class="nav-link">
                  <?php } ?>
                  <i class="nav-icon fas fa-barcode"></i>
                  <p>
                    List of Scanned
                  </p>
                </a>
            </li>
            <li class="nav-item">
              <?php if ($_SERVER['REQUEST_URI'] == "/inventory/admin_manual.php") { ?>
                <a href="admin_manual.php" class="nav-link active">
                <?php } else { ?>
                  <a href="admin_manual.php" class="nav-link">
                  <?php } ?>
                  <i class="nav-icon fas fa-user-cog"></i>
                  <p>
                    List of Manual
                  </p>
                </a>
            </li>






            <li class="nav-item">
              <a href="#" class="nav-link" data-toggle="modal" data-target="#logout-modal">
                <i class="nav-icon far fa-circle text-danger"></i>
                <p class="text">Logout</p>
              </a>
            </li>
          </ul>
        </nav>
        <!-- /.sidebar-menu -->
      </div>
      <!-- /.sidebar -->
    </aside>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1>List of Manual</h1>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active">List of Manual</li>
              </ol>
            </div>
          </div>
        </div>
      </section>








      <section class="content">
        <div class="container-fluid">
          <div class="row">
            <!-- left column -->
            <div class="col-md-12">
              <!-- general form elements -->
              <div class="card card-primary">
                <div class="card-header">
                  <h3 class="card-title">
                  </h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form>
                  <div class="card-body">

                    <div class="row">
                      <div class="col-12">
                        <div class="card">
                          <div class="card-header">
                            <h3 class="card-title col-12">
                              <div class="row">
                                <div class="col-lg-12 col-md-12 col-sm-12">
                                  <div class="float-right">
                                    <a href="#" class="btn btn-success" onclick="export_admin_manual()">Export
                                      Data&ensp;<i class="fas fa-download"></i></a>
                                  </div>
                                </div>
                              </div>
                            </h3>
                          </div>





                          <div class="card-body table-responsive p-0" style="height: 500px;">
                            <table class="table table-head-fixed text-nowrap table-hover">
                              <thead style="text-align:center;">
                                <th>ID</th>
                                <th>Parts Code</th>
                                <th>Parts Name</th>
                                <th>Date and Time</th>
                                <th>Section</th>
                                <th>Location</th>
                                <th>Verified Quantity</th>
                              </thead>
                              <tbody id="list_of_scanned_admin" style="text-align:center;">
                                <?php include 'process/admin_manual_fetch.php'; ?>
                              
                              </tbody>
                            </table>
                          </div>
                          <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                      </div>
                    </div>

                  </div>
                  <!-- /.card-body -->
                </form>
              </div>
              <!-- /.card -->
            </div>
            <!--/.col (right) -->
          </div>
        </div>
        <!-- Pagination Section -->
<div class="pagination-section">
  <div class="container-fluid">
    <div class="row justify-content-center">
      <nav aria-label="Page navigation">
        <ul class="pagination">
                   <!-- Current page number -->
       
          <li class="page-item active">
            <span class="page-link"><?php echo $current_page; ?></span>
          </li>
   <!-- Previous page button -->

          <li class="page-item <?php echo ($current_page == 1) ? 'disabled' : ''; ?>">
            <a class="page-link" href="admin_manual.php?page=<?php echo $current_page - 1; ?>"><<</a>
          </li>
 
          
          <!-- Next page button -->
          <li class="page-item <?php echo ($current_page == $total_pages) ? 'disabled' : ''; ?>">
            <a class="page-link" href="admin_manual.php?page=<?php echo $current_page + 1; ?>">>></a>
          </li>
          <!-- Last page number -->
          <li class="page-item <?php echo ($current_page == $total_pages) ? 'disabled' : ''; ?>">
            <a class="page-link" href="admin_manual.php?page=<?php echo $total_pages; ?>"><?php echo $total_pages; ?></a>
          </li>
        </ul>
      </nav>
    </div>
  </div>
</div>
<!-- End Pagination Section -->
      </section>
      <!-- /.content -->
    </div>





    <footer class="main-footer">
      <strong>Copyright &copy; 2024. Developed by: M.Omabtang</strong>
      All rights reserved.
      <div class="float-right d-none d-sm-inline-block">
        <b>Version</b> 1.0.0
      </div>
    </footer>
    <?php
    include 'modals/logout.php';
    ?>
    <!-- jQuery -->
    <script src="plugins/jquery/dist/jquery.min.js"></script>
    <!-- jQuery UI 1.11.4 -->
    <script src="plugins/jquery-ui/jquery-ui.min.js"></script>
    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
    <script>
      $.widget.bridge('uibutton', $.ui.button)
    </script>
    <!-- Bootstrap 4 -->
    <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- overlayScrollbars -->
    <script src="plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
    <!-- SweetAlert2 -->
    <script type="text/javascript" src="plugins/sweetalert2/dist/sweetalert2.min.js"></script>
    <!-- AdminLTE App -->
    <script src="dist/js/adminlte.js"></script>

    <script type="text/javascript">
      const export_admin_manual = () => {
        window.open('process/export_scanned_manual.php');
      }
    </script>

  </body>

  </html>

