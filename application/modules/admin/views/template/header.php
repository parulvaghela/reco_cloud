<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php echo (isset($title) && !empty($title)) ? $title : DEFAULT_META_TITLE; ?></title>	
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?php echo (isset($meta_description) && !empty($meta_description)) ? $meta_description : DEFAULT_META_DESCRIPTION; ?>"/>
    <meta name="keywords" content="<?php echo (isset($meta_keyword) && !empty($meta_keyword)) ? $meta_keyword : DEFAULT_META_KEYWORD; ?>"/>
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="<?php echo ADMIN_DESIGN; ?>images/favicon.png">
	<link rel="stylesheet" href="<?php echo ADMIN_DESIGN; ?>vendor/chartist/css/chartist.min.css">
    <link href="<?php echo ADMIN_DESIGN; ?>vendor/bootstrap-select/dist/css/bootstrap-select.min.css" rel="stylesheet">
	<link href="<?php echo ADMIN_DESIGN; ?>vendor/owl-carousel/owl.carousel.css" rel="stylesheet">
    <link href="<?php echo ADMIN_DESIGN; ?>css/style.css" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&family=Roboto:wght@100;300;400;500;700;900&display=swap" rel="stylesheet">
  <!--Datatable css-->
    <link href="<?php echo ADMIN_DESIGN; ?>vendor/datatables/css/jquery.dataTables.min.css" rel="stylesheet">
  <!-----summernote--->

    <link href="<?php echo ADMIN_DESIGN; ?>vendor/summernote/summernote.css" rel="stylesheet">


    <!--**********************************
      Scripts
  ***********************************-->
  <script>
   var base_url = "<?php echo base_url(); ?>";
  </script>
  <!-- Required vendors -->
  <script src="<?php echo ADMIN_DESIGN; ?>vendor/global/global.min.js"></script>
<script src="<?php echo ADMIN_DESIGN; ?>vendor/bootstrap-select/dist/js/bootstrap-select.min.js"></script>
<script src="<?php echo ADMIN_DESIGN; ?>vendor/chart.js/Chart.bundle.min.js"></script>
  <script src="<?php echo ADMIN_DESIGN; ?>js/custom.min.js"></script>
<script src="<?php echo ADMIN_DESIGN; ?>js/deznav-init.js"></script>
<script src="<?php echo ADMIN_DESIGN; ?>vendor/owl-carousel/owl.carousel.js"></script>

<!-- Chart piety plugin files -->
  <script src="<?php echo ADMIN_DESIGN; ?>vendor/peity/jquery.peity.min.js"></script>

<!-- Apex Chart -->
<script src="<?php echo ADMIN_DESIGN; ?>vendor/apexchart/apexchart.js"></script>
  <!-- Jquery Validation -->
  <script src="<?php echo ADMIN_DESIGN; ?>vendor/jquery-validation/jquery.validate.min.js"></script>
  <!-- Form validate init -->
    <script src="<?php echo ADMIN_DESIGN; ?>js/plugins-init/jquery.validate-init.js"></script>
<script src="<?php echo ASSETS_PATH.'config.js' ?>"></script>
  <!-- datatable js -->
  <script src="<?php echo ADMIN_DESIGN; ?>vendor/datatables/js/jquery.dataTables.min.js"></script>
  <!-----summernote--->
  <script src="<?php echo ADMIN_DESIGN; ?>vendor/summernote/js/summernote.min.js"></script>



</head>