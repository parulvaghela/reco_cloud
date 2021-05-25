<!DOCTYPE html>

<html lang="en">

<head>

  <meta charset="utf-8">

  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>Forgot Password</title>



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

  <div class="card">

    <div class="card-body login-card-body">

      <p class="login-box-msg">You forgot your password? Here you can easily retrieve a new password.</p>

        <?php

        $flash = $this->session->flashdata('forgot_error');

        if ($flash) {

            echo $flash;

        }

        ?>

      <form action="<?php echo base_url(); ?>forgot_password" name="forgot_form" method="post">

        <div class="input-group mb-3">

          <input type="email" class="form-control" name="email_id" id="email_id" placeholder="Email">

          <div class="input-group-append">

            <div class="input-group-text">

              <span class="fas fa-envelope"></span>

            </div>

          </div>

        </div>

        <label id="email_id-error" class="error text-danger" for="email_id"></label>

        <div class="row">

          <div class="col-12">

            <button type="submit" class="btn btn-primary btn-block">Request new password</button>

          </div>

          <!-- /.col -->

        </div>

      </form>



      <p class="mt-3 mb-1">

        <a href="<?php echo BASE_URL ?>login">Login</a>

      </p>

      <p class="mb-0">

        <a href="<?php echo BASE_URL ?>register" class="text-center">Register a new user</a>

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

<script>
    $(document).ready(function(){
        $.validator.addMethod("email_check", function(value, element) {
            return this.optional(element) || /^\b[A-Z0-9._%-]+@[A-Z0-9.-]+\.[A-Z]{2,4}\b$/i.test(value);
        });
        $("form[name='forgot_form']").validate({
            errorClass: 'error',
            rules: {
                email_id: {
                    required: true,
                    email:true,
                    email_check:true
                }
            },
            messages: {
                email_id: {
                    required: "please Enter Email Address",
                    email_check:"Please enter valid email address"
                }
            },
            submitHandler: function (form) {
                form.submit();
            }
        });
    });
</script>
</body>
</html>