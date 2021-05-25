$(document).ready(function () {
    $.validator.addMethod("pwcheck", function (value) {
        return /[a-z]/.test(value)
                && /[A-Z]/.test(value)
                && /\d/.test(value)
                && /[@$!%*#?&]/.test(value)
    });

    $("form[name='change_password_validate']").validate({
        errorClass: 'errors',
        rules: {
            old_pass: {
                required: true,
                remote: {
                    url: base_url + 'check_old_password',
                    type: "post"
                }

            },
            new_pass: {
                required: true,
                pwcheck: true,
                minlength: 8,
                maxlength: 20

            },
            con_pass: {
                required: true,
                equalTo: "#new_pass",
                pwcheck: true,
                minlength: 8
            },
        },
        messages: {
            old_pass: {
                required: "Old password field is required",
                remote: "Old password can not be same"
            },
            new_pass: {
                required: "New password field is required",
                pwcheck: "*The password does not meet the criteria! <br/>(Password must have atleast 8 characters <br/> 1) Upper letters <br/> 2) Lower letters <br/> 3) Numbers and <br/> 4) Special characters)",
                minlength: "*Your password must be at least 8 characters long"
            },
            con_pass: {
                required: "Confirm password field is required",
                equalTo: "Confirm password must be same as new password",
                pwcheck: "*The password does not meet the criteria! <br/>(Password must have atleast 8 characters <br/> 1) Upper letters <br/> 2) Lower letters <br/> 3) Numbers and <br/> 4) Special characters)",
                minlength: "*Your password must be at least 8 characters long"
            }
        },
        submitHandler: function (form) {
            form.submit();
        }
    });

});
$('#new_pass').bind("change keyup input", function() {
    var limitNum = 20;
    if ($(this).val().length > limitNum) {
        $(this).val($(this).val().substring(0, limitNum));
    }
  });
