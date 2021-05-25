<!DOCTYPE html>
<html lang="en" class="h-100">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Set New Password</title>
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
                                    <h4 class="text-center mb-4 text-white">Set New Password</h4>
                                    <form action="<?php echo base_url(); ?>admin/set-new-password" name="set_new_pass" method="post">
                                      <?php
                                        $flash = $this->session->flashdata('forgot_error');
                                        if ($flash) {
                                            echo $flash;
                                        }
                                      ?>
                                        <div class="form-group">
                                            <label class="text-white"><strong>New Password</strong></label>
                                            <input type="password" class="form-control" name="newpwd" id="newpwd" placeholder="New Password">
                                        </div>
                                        <div class="form-group">
                                            <label class="text-white"><strong>Confirm Password</strong></label>
                                            <input type="password" class="form-control" name="cfpwd" id="cfpwd" placeholder="Confirm Password">
                                        </div>
                                        <input type="hidden" value="<?= $userinfo['id'] ?>" name="userid">
                                        <input type="hidden" value="<?= $userinfo['forgot_code'] ?>" name="fcode">

                                        <div class="text-center">
                                            <button type="submit" class="btn bg-white text-primary btn-block">Set new password</button>
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
    <script src="<?php echo ASSETS_PATH.'config.js' ?>"></script>
    <script>
    $(document).ready(function(){
        $.validator.addMethod("p_match", function(value, element) {
            return this.optional(element) || /^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#\$%\^&\*])(?=.{8,})/.test(value);
        });
        $("form[name='set_new_pass']").validate({
            errorClass: 'errors',
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