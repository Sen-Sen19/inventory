<style>
  .main-footer {
  position: fixed;
  left: 0;
  bottom: 0;
  width: 100%;
  background-color: #f8f9fa; 
  color:#7c7a79; 
  padding: 10px 20px; 
}

</style>

<footer class="main-footer">
    <strong>Copyright &copy; 2024. Developed by: M.N Omabtang</strong>
    All rights reserved.
    <div class="float-right d-none d-sm-inline-block">
      <b>Version</b> 1.0.0
    </div>
  </footer>
<?php 
include 'modals/scanning.php';
include 'modals/scanning_initial.php';
include 'modals/update_qty.php';
include 'modals/update_qty_initial.php';
include 'modals/initial_verified_qty.php';
include 'modals/verified_qty.php';

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
</body>
</html>