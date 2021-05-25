function checkLength() {
    var fieldLength = document.getElementById('e_umobile').value.length;
    //Suppose u want 4 number of character
    if (fieldLength <= 13) {
        return true;
    } else
    {
        var str = document.getElementById('e_umobile').value;
        str = str.substring(0, str.length - 1);
        document.getElementById('e_umobile').value = str;
    }
}
$('#e_ufirst_name,#e_ulast_name').bind("change keyup input", function() {
    var limitNum = 20;
    if ($(this).val().length > limitNum) {
        $(this).val($(this).val().substring(0, limitNum));
    }
});
$(document).ready(function(){
	$.validator.addMethod("pass_match", function(value, element) {

        return this.optional(element) || /^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#\$%\^&\*])(?=.{8,})/.test(value);

    });
	$.validator.addMethod("email_check", function(value, element) {

        return this.optional(element) || /^\b[A-Z0-9._%-]+@[A-Z0-9.-]+\.[A-Z]{2,4}\b$/i.test(value);

    });
    $.validator.addMethod("alpha", function(value, element) {
        return this.optional(element) || /^[a-zA-Z ]*$/.test(value);
    });
    $.validator.addMethod("num_only", function(value, element) {
        return this.optional(element) || /^[0-9]*$/.test(value);
    });


	$('#user_edit_validate_js').validate({
		errorClass: 'errors',
			rules: {
            e_urole:{
                required: true,
            },
            e_ufirst_name: {
                required: true,
                alpha:true,
                minlength:3,
                maxlength:20
            },
            e_ulast_name: {
                required: true,
                alpha:true,
                minlength:3,
                maxlength:20
            },
            e_uemail: {
                required: true,
                email: true,
                email_check: true,
            },
            e_umobile:{
                required: true,
                num_only:true,
                minlength:10,
                maxlength:13
            },
            e_udob:{
                required: true,
            },
             e_ugender:{
                required: true,
            },
            e_ustatus:{
                required: true,
            },

              e_upassword: {
                required: true,
                pass_match: true,
                minlength: 8,
                maxlength:20
            },
            e_ucpassword: {
                required: true,
                equalTo: e_upassword
            },
            'permission[]' :{
                required: true,
            }
           
        },	
        messages: {
            e_urole:{
                required: "Role field is required",
            },

            e_ufirst_name: {

                required: "Name field is required",
                alpha: "Enter alpha only"

            },
             e_ulast_name: {

                required: "Last Name field is required",
                alpha: "Enter alpha only"

            },

            e_uemail: {
                required: "Email address field is required",
                email_check: 'Enter valid email address',
            },
            e_umobile:{
                required: "Mobile field is required",
                num_only:"Phone number must be number only"
            },
            e_ugender:{
                required: "Gender field is required",
            },
            e_ustatus:{
                required: "Status field is required",
            },
            e_upassword: {
                required: "Password field is required",
                pass_match: "*The password does not meet the criteria! <br/>(Password must have atleast 8 characters <br/> 1) Upper letters <br/> 2) Lower letters <br/> 3) Numbers and <br/> 4) Special characters)",
                minlength: "*Your password must be at least 8 characters long"
            },

            e_ucpassword: {
                required: "confirm password field is required",
                equalTo: "Confirm password not match"
            },
            e_udob:{
                required: 'Date Of birth is required',
            },
            'permission[]' :{
                required: 'Permission field required',
            }

           
        },
        submitHandler: function(form) {

            form.submit();

        }
	});
});