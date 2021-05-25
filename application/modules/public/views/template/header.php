<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Dashboard</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?php echo PLUGINS_PATH.'fontawesome-free/css/all.min.css' ?>">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Tempusdominus Bootstrap 4 -->
  <link rel="stylesheet" href="<?php echo PLUGINS_PATH.'tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css' ?>">
  <!-- iCheck -->
  <link rel="stylesheet" href="<?php echo PLUGINS_PATH.'icheck-bootstrap/icheck-bootstrap.min.css' ?>">

  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo FRONT_DESIGN.'css/adminlte.min.css' ?>">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="<?php echo PLUGINS_PATH.'overlayScrollbars/css/OverlayScrollbars.min.css' ?>">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="<?php echo PLUGINS_PATH.'daterangepicker/daterangepicker.css' ?>">
  <!-- summernote -->
  <link rel="stylesheet" href="<?php echo PLUGINS_PATH.'summernote/summernote-bs4.min.css' ?>">
  <!-- DataTables -->
  <link rel="stylesheet" href="<?php echo PLUGINS_PATH.'datatables-bs4/css/dataTables.bootstrap4.min.css' ?>">
  <link rel="stylesheet" href="<?php echo PLUGINS_PATH.'datatables-responsive/css/responsive.bootstrap4.min.css' ?>">
  <link rel="stylesheet" href="<?php echo PLUGINS_PATH.'datatables-buttons/css/buttons.bootstrap4.min.css' ?>">
    <!-- select2 -->
  <link rel="stylesheet" href="<?php echo PLUGINS_PATH.'select2/css/select2.min.css'?>">
    <!------------------------style --------------------------------- -->
  <link rel="stylesheet" href="<?php echo CUSTOM_CLIENT_CSS; ?>style.css">
  <!-- jQuery -->
<script src="<?php echo PLUGINS_PATH.'jquery/jquery.min.js' ?>"></script>
<!-- jQuery UI 1.11.4 -->
<script src="<?php echo PLUGINS_PATH.'jquery-ui/jquery-ui.min.js' ?>"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  //$.widget.bridge('uibutton', $.ui.button)
  var base_url = '<?php echo base_url(); ?>';
</script>
<!-- Bootstrap 4 -->
<script src="<?php echo PLUGINS_PATH.'bootstrap/js/bootstrap.bundle.min.js' ?>"></script>
<script src="https://cdn.ckeditor.com/4.15.1/standard/ckeditor.js"></script>
<script src="<?php echo ASSETS_PATH.'config.js' ?>"></script>
<!-- DataTables  & Plugins -->
<script src="<?php echo PLUGINS_PATH.'datatables/jquery.dataTables.min.js' ?>"></script>
<script src="<?php echo PLUGINS_PATH.'datatables-bs4/js/dataTables.bootstrap4.min.js' ?>"></script>
<script src="<?php echo PLUGINS_PATH.'datatables-responsive/js/dataTables.responsive.min.js' ?>"></script>
<script src="<?php echo PLUGINS_PATH.'datatables-responsive/js/responsive.bootstrap4.min.js' ?>"></script>
<script src="<?php echo PLUGINS_PATH.'datatables-buttons/js/dataTables.buttons.min.js' ?>"></script>
<script src="<?php echo PLUGINS_PATH.'datatables-buttons/js/buttons.bootstrap4.min.js' ?>"></script>
<script src="<?php echo PLUGINS_PATH.'jszip/jszip.min.js' ?>"></script>
<script src="<?php echo PLUGINS_PATH.'pdfmake/pdfmake.min.js' ?>"></script>
<script src="<?php echo PLUGINS_PATH.'pdfmake/vfs_fonts.js' ?>"></script>
<script src="<?php echo PLUGINS_PATH.'datatables-buttons/js/buttons.html5.min.js' ?>"></script>
<script src="<?php echo PLUGINS_PATH.'datatables-buttons/js/buttons.print.min.js' ?>"></script>
<script src="<?php echo PLUGINS_PATH.'datatables-buttons/js/buttons.colVis.min.js' ?>"></script>

<!-- daterangepicker -->
<script src="<?php echo PLUGINS_PATH.'moment/moment.min.js' ?>"></script>
<script src="<?php echo PLUGINS_PATH.'daterangepicker/daterangepicker.js' ?>"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="<?php echo PLUGINS_PATH.'tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js' ?>"></script>
<!-- Summernote -->
<script src="<?php echo PLUGINS_PATH.'summernote/summernote-bs4.min.js' ?>"></script>
<!-- overlayScrollbars -->
<script src="<?php echo PLUGINS_PATH.'overlayScrollbars/js/jquery.overlayScrollbars.min.js' ?>"></script>
<!-- AdminLTE App -->
<script src="<?php echo FRONT_DESIGN.'js/adminlte.js' ?>"></script>
<!-- AdminLTE for demo purposes -->
<script src="<?php echo FRONT_DESIGN.'js/demo.js' ?>"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="<?php echo FRONT_DESIGN.'js/pages/dashboard.js' ?>"></script>
<!--- select2 js --->
<script src="<?php echo PLUGINS_PATH.'select2/js/select2.min.js' ?>"></script>
<!-- jquery validation -->
<script src="https://cdn.jsdelivr.net/jquery.validation/1.15.1/jquery.validate.min.js"></script>
<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/additional-methods.min.js"></script>
<style>
.errors{
  color:red
}
</style>
</head>