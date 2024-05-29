<?php include 'tools/navbar.php'; ?>
<?php include 'tools/sidebar/scannedbar.php'; ?>


<div class="content-wrapper">
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">List of Scanned</h1>
          <br>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">List of Scanned</li>
          </ol>
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
  <!-- /.content-header -->

  <!-- Main content -->
   <section class="content">
    <div class="container-fluid">
      <div class="row">
        <!-- left column -->
        <div class="col-md-12">
          <!-- general form elements -->
          <div class="card card-info">
            <div class="card-header">
              <h3 class="card-title"></h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form>
              <div class="card-body">
                <div class="row">
                  <div class="col-3">
                    <span> Section: </span>
                    <select id="section_name_scanned_final" class="form-control"
                      onchange="section_check_scanned_final()">
                      <option value="">Select Section</option>
                    </select>
                  </div>
                  <div class="col-3">
                    <span> Location: </span>
                    <select id="line_names_scanned_final" class="form-control">
                      <option value="">Select Location</option>
                    </select>
                  </div>
                  <div class="col-3">
                    <span>Parts Code:</span>
                    <input type="text" id="parts_code_search" class="form-control" autocomplete="off">
                  </div>
                  <div class="col-3">
                    <div class="float-right">
                      <a href="#" class="btn btn-primary" onclick="search_scanned()">Search</a>
                    </div>
                  </div>
                </div>
                <br>
                <div class="row">
                  <div class="col-4">
                    <!-- <a href="#" class="btn btn-success" onclick="export_scanned()">Export All</a> -->
                  </div>
                  <div class="col-8">
                    <div class="float-right">
                      <!-- <a href="#" class="btn btn-success" onclick="export_scanned_filtered()">Export Filtered</a> -->
                    </div>
                  </div>
                </div>
                <br>
                <div class="row">
                  <div class="col-12">
                    <div class="card-body table-responsive p-0" style="height:500px;">
                      <table class="table table-head-fixed text-nowrap table-hover" id="">
                        <thead style="text-align:center;">
                          <th>#</td>
                          <th>Inventory Tag No</th>
                          <th>Location Code</th>
                          <th>Part Code</th>
                          <th>Part Name</th>
                          <th>Physical Count</th>
                          <th>Verified QTY</th>
                          <th>Length</th>
                          <th>Location</th>
                        </thead>
                        <tbody id="list_of_scanned" style="text-align:center;"></tbody>
                      </table>
                      <div class="row">
                        <div class="col-6"></div>
                        <div class="col-6">
                          <div class="spinner" id="spinner" style="display:none;">
                            <div class="loader float-sm-center"></div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <!-- /.card-body -->

              <div class="card-footer">

              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>





<?php include 'tools/footer.php'; ?>
<?php include 'tools/javascript/scanned_script.php'; ?>