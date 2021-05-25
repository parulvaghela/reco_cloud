$(document).ready(function(){
    $.validator.addMethod("email_check", function(value, element) {
    return this.optional(element) || /^\b[A-Z0-9._%-]+@[A-Z0-9.-]+\.[A-Z]{2,4}\b$/i.test(value);
    });

    $("form[name='login_form']").validate({
        errorClass: 'errors',
        rules:{
            email:{
                required:true,
                email:true,
                email_check:true
            },
            password:{
                required:true
            }

        },
        messages:{
            email:{
                required:"please enter Username",
                email_check:'Enter valid email address'
           },
           password:{
                required:"password is required"
           }
        },
        submitHandler: function(form) {
           form.submit();
       }
    });
});