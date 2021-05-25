<!DOCTYPE html>
<html lang="en" class="h-100">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Forgot Password</title>
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="<?php echo ADMIN_DESIGN; ?>images/favicon.png">
    <link href="<?php echo ADMIN_DESIGN; ?>css/style.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&family=Roboto:wght@100;300;400;500;700;900&display=swap" rel="stylesheet">
</head>

<body class="h-100">
    <div class="authincation h-100">
        <div class="container h-100">
            <div class="row justify-content-center h-100 align-items-center">
                <div class="col-md-6">
                    <div class="authincation-content">
                        <div class="row no-gutters">
                            <div class="col-xl-12">
                                <div class="auth-form">
                                    <div class="text-center mb-3">
                                      <a href="index.html"><img src="<?php echo ADMIN_DESIGN; ?>images/logo-full.png" alt=""></a>
                                    </div>
                                    <h4 class="text-center mb-4 text-white">Forgot Password</h4>
                                    <form action="<?php echo base_url(); ?>admin/forgot-password" name="forgot_form" method="post">
                                      <?php
                                        $flash = $this->session->flashdata('forgot_error');
                                        if ($flash) {
                                            echo $flash;
                                        }
                                      ?>
                                        <div class="form-group">
                                            <label class="text-white"><strong>Email</strong></label>
                                            <input type="email" name="email_id" id="email_id" class="form-control" placeholder="Email Address">
                                        </div>
                                        <div class="text-center">
                                            <button type="submit" class="btn bg-white text-primary btn-block">Request new password</button>
                                        </div>
                                    </form>
                                    <div class="new-account mt-3">
                                      <p class="text-white"><a class="text-white" href="<?php echo base_url(); ?>admin/login">Back To Login</a></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!--**********************************
        Scripts
    ***********************************-->
    <!-- Required vendors -->
    <script src="<?php echo ADMIN_DESIGN; ?>vendor/global/global.min.js"></script>
	<script src="<?php echo ADMIN_DESIGN; ?>vendor/bootstrap-select/dist/js/bootstrap-select.min.js"></script>
    <script src="<?php echo ADMIN_DESIGN; ?>js/custom.min.js"></script>
    <script src="<?php echo ADMIN_DESIGN; ?>js/deznav-init.js"></script>
         <!-- Jquery Validation -->
         <script src="<?php echo ADMIN_DESIGN; ?>vendor/jquery-validation/jquery.validate.min.js"></script>
    <!-- Form validate init -->
    <script src="<?php echo ADMIN_DESIGN; ?>js/plugins-init/jquery.validate-init.js"></script>
    <script>
    $(document).ready(function(){
        $.validator.addMethod("email_check", function(value, element) {
            return this.optional(element) || /^\b[A-Z0-9._%-]+@[A-Z0-9.-]+\.[A-Z]{2,4}\b$/i.test(value);
        });
        $("form[name='forgot_form']").validate({
            errorClass: 'errors',
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