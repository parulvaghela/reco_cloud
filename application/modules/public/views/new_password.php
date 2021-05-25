<!DOCTYPE html>

<html lang="en">

<head>

  <meta charset="utf-8">

  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>Set New Password</title>



  <!-- Google Font: Source Sans Pro -->

  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">

  <!-- Font Awesome -->

  <link rel="stylesheet" href="<?php echo PLUGINS_PATH ?>fontawesome-free/css/all.min.css">

  <!-- icheck bootstrap -->

  <link rel="stylesheet" href="<?php echo PLUGINS_PATH ?>icheck-bootstrap/icheck-bootstrap.min.css">

  <!-- Theme style -->

  <link rel="stylesheet" href="<?php echo FRONT_DESIGN ?>css/adminlte.min.css">

</head>

<body class="hold-transition login-page">

<div class="login-box">

  <div class="login-logo">

  </div>

  <!-- /.login-logo -->

  <div class="card card-outline card-primary">

    <div class="card-header text-center">
      <a href="#" class="h1">New Password</a>
    </div> 
    <div class="card-body login-card-body">

     <?php

        $flash = $this->session->flashdata('forgot_error');

        if ($flash) {

            echo $flash;

        }

        ?>

      <form action="<?php echo base_url(); ?>set_new_password" name="set_new_pass" method="post">

        <div class="input-group mb-3">

          <input type="password" class="form-control" name="newpwd" id="newpwd" placeholder="New Password">

          <div class="input-group-append">

            <div class="input-group-text">

              <span toggle="#password-field" data-id="newpwd" class="fa fa-fw fa-eye field_icon toggle-password"></span>

            </div>

          </div>

        </div>

        <label id="newpwd-error" class="error text-danger" for="newpwd" style="display:none;"></label>

        <div class="input-group mb-3">

          <input type="password" class="form-control" name="cfpwd" id="cfpwd" placeholder="Confirm Password">

          <div class="input-group-append">

            <div class="input-group-text">

               <span toggle="#password-field" data-id="cfpwd" class="fa fa-fw fa-eye field_icon toggle-password"></span>

            </div>

          </div>

        </div>

        <label id="cfpwd-error" class="error text-danger" for="cfpwd" style="display:none;"></label>

        <input type="hidden" value="<?= $userinfo['id'] ?>" name="userid">

        <input type="hidden" value="<?= $userinfo['forgot_code'] ?>" name="fcode">

        <div class="row">

          <div class="col-12">

            <button type="submit" class="btn btn-primary btn-block">Set new password</button>

          </div>

          <!-- /.col -->

        </div>

      </form>



      <p class="mt-3 mb-1">

        <a href="<?php echo BASE_URL.'login' ?>">Login</a>

      </p>

      <p class="mb-0">

        <a href="<?php echo BASE_URL.'register' ?>" class="text-center">Register a new user</a>

      </p>

    </div>

    <!-- /.login-card-body -->

  </div>

</div>

<!-- /.login-box -->



<!-- jQuery -->

<script src="<?php echo PLUGINS_PATH ?>jquery/jquery.min.js"></script>
<script src="https://ajax.aspnetcdn.com/ajax/jquery.validate/1.14.0/jquery.validate.min.js"></script>
<!-- Bootstrap 4 -->
<script src="<?php echo PLUGINS_PATH ?>bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="<?php echo FRONT_DESIGN ?>js/adminlte.min.js"></script>
<script src="<?php echo ASSETS_PATH.'config.js' ?>"></script>
<script>
    $(document).ready(function(){
        $.validator.addMethod("p_match", function(value, element) {
            return this.optional(element) || /^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#\$%\^&\*])(?=.{8,})/.test(value);
        });
        $("form[name='set_new_pass']").validate({
            errorClass: 'error',
            rules: {
                newpwd: {
                    required: true,
                    p_match: true,
                    minlength: 8,
                    maxlength: 20
                },
                cfpwd: {
                    required: true,
                    equalTo: newpwd
                }
            },
            messages: {
                newpwd: {
                    required: "please Enter New password",
                    p_match: "*The password does not meet the criteria! <br/>(Password must have atleast 8 characters <br/> 1) Upper letters <br/> 2) Lower letters <br/> 3) Numbers and <br/> 4) Special characters)",
                    minlength: "*Your password must be at least 8 characters long"
                },
                cfpwd: {
                    required: "please Enter confirm password",
                    equalTo: "Confirm password Doesn't match"
                }
            },
            submitHandler: function (form) {
                form.submit();
            }
        });
    });
    $('#newpwd').bind("change keyup input", function() {
    var limitNum = 20;
    if ($(this).val().length > limitNum) {
        $(this).val($(this).val().substring(0, limitNum));
    }
});
</script>
</body>
</html>