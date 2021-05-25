<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>New Reputation</title>
  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?php echo PLUGINS_PATH; ?>fontawesome-free/css/all.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="<?php echo PLUGINS_PATH; ?>icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo FRONT_DESIGN; ?>css/adminlte.min.css">
  <script>
      var base_url = '<?php echo base_url(); ?>';
  </script>
  <style>
  .errors{
    color:red;
  }
 .register-box {
  width: 50%;
  @media (max-width: map-get($grid-breakpoints, sm)) {
    margin-top: .5rem;
    width: 90%;
  }
  .card {
    margin-bottom: 0;
  }
}
  </style>
</head>
<body class="hold-transition register-page">
<div class="register-box">
  <div class="card card-outline card-primary">
    <div class="card-header text-center">
      <a href="javascript:void(0)" class="h1">MICROSOFT</a>
    </div>
    <div class="card-body">
      <p class="login-box-msg">Register a new user</p>
      <form action="<?php echo base_url(); ?>register" name="register_form" method="post" enctype="multipart/form-data">
      <?php
        $flash = $this->session->flashdata('reg_error');
        if ($flash) {
            echo $flash;
        }
        ?>
        <div class="row">
            <div class="col-md-6">
              <div class="input-group mb-3">
                <input type="text" name="first_name" id="first_name" class="form-control" placeholder="First name" onkeypress="return isalpha(event);">
                <div class="input-group-append">
                  <div class="input-group-text">
                    <span class="fas fa-user"></span>
                  </div>
                </div>
              </div>
                <span class="errors"><?php echo form_error('first_name'); ?></span>
                <label id="first_name-error" class="errors" for="first_name" style="display:none;"></label>
            </div>
            <div class="col-md-6">
              <div class="input-group mb-3">
                <input type="text" name="last_name" id="last_name" class="form-control" placeholder="Last name" onkeypress="return isalpha(event);">
                <div class="input-group-append">
                  <div class="input-group-text">
                    <span class="fas fa-user"></span>
                  </div>
                </div>
              </div>
              <span class="errors"><?php echo form_error('last_name'); ?></span>
              <label id="last_name-error" class="errors" for="last_name" style="display:none;"></label>
            </div>
        </div>
        <div class="row">
          <div class="col-md-6">
            <div class="input-group mb-3">
              <input type="email" name="email" id="email" class="form-control" placeholder="Email">
              <div class="input-group-append">
                <div class="input-group-text">
                  <span class="fas fa-envelope"></span>
                </div>
              </div>
            </div>
            <span class="errors"><?php echo form_error('email'); ?></span>
            <label id="email-error" class="errors" for="email" style="display:none;"></label>
          </div>
          <div class="col-md-6">
            <div class="input-group mb-3">
                <input type="text" name="phone_no" id="phone_no" class="form-control" placeholder="Phone Number" onkeypress="return isNumber(event);" onInput="checkLength()">
                <div class="input-group-append">
                  <div class="input-group-text">
                    <span class="fas fa-phone"></span>
                  </div>
                </div>
              </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-6">
              <div class="input-group mb-3">
                <input type="password" name="password" id="password" class="form-control" placeholder="Password">
                <div class="input-group-append">
                  <div class="input-group-text">
                  <span toggle="#password-field" data-id="password" class="fa fa-fw fa-eye field_icon toggle-password"></span>
                  </div>
                </div>
              </div>
              <span class="errors"><?php echo form_error('password'); ?></span>
              <label id="last_name-error" class="errors" for="password" style="display:none;"></label>
          </div>
          <div class="col-md-6">
            <div class="input-group mb-3">
                <input type="password" name="c_password" id="cpass" class="form-control" placeholder="Retype password">
                <div class="input-group-append">
                  <div class="input-group-text">
                    <span toggle="#password-field" data-id="cpass" class="fa fa-fw fa-eye field_icon toggle-password"></span>
                  </div>
                </div>
              </div>
              <span class="errors"><?php echo form_error('c_password'); ?></span>
              <label id="cpass-error" class="errors" for="cpass" style="display:none;"></label>
            </div>
        </div>
        <div class="row">
          <div class="col-md-6">
            <label for="profile_pic">Profile Picture</label>
            <div class="input-group mb-3">
              <input type="file" name="profile_pic" id="profile_pic" accept="image/*" class="form-control">
            </div>
            <label id="profile_pic-error" class="errors" for="profile_pic" style="display:none;"></label>
          </div>
        </div>
        <div class="row">
          <div class="col-9">
            <div class="icheck-primary">
              <input type="checkbox" name="agreeterms" id="agreeterms" name="terms" value="agree">
              <label for="agreeterms">
               I agree to the <a href="#">terms</a>
              </label>
            </div>
            <label id="agreeterms-error" class="errors" for="agreeterms" style="display:none;"></label>
          </div>
          <!-- /.col -->
          <div class="col-3">
            <button type="submit" name="register" class="btn btn-primary btn-block">Register</button>
          </div>
          <!-- /.col -->
        </div>
      </form>
      <div class="social-auth-links text-center">
        <p>- OR -</p>
       <div class="row">
         <div class="col-6">
           <a href="<?php echo base_url(); ?>facebook_reg" class="btn btn-block btn-primary fb_btn">
             <i class="fab fa-facebook mr-2"></i>
             Sign up using Facebook
           </a>
         </div>
         <div class="col-6">
           <a href="<?php echo base_url(); ?>google_register" class="btn btn-block btn-danger">
              <i class="fab fa-google-plus mr-2"></i>
              Sign up using Google
            </a>
          </div>
        </div>
        </div>
      <a href="<?php echo base_url(); ?>login" class="text-center">I already have a user</a>
    </div>
    <!-- /.form-box -->
  </div><!-- /.card -->
</div>
<script src="<?php echo PLUGINS_PATH; ?>jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="<?php echo PLUGINS_PATH; ?>bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<!-- jquery validation -->
<script src="https://cdn.jsdelivr.net/jquery.validation/1.15.1/jquery.validate.min.js"></script>
<script src="<?php echo FRONT_DESIGN; ?>js/adminlte.min.js"></script>
<script src="<?php echo ASSETS_PATH.'config.js' ?>"></script>
<script src="<?php echo COMMON_JS.'register.js' ?>"></script>
</body>
</html>
