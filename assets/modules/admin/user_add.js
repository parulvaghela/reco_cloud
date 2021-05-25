function checkLength() {
    var fieldLength = document.getElementById('umobile').value.length;
    //Suppose u want 4 number of character
    if (fieldLength <= 13) {
        return true;
    } else
    {
        var str = document.getElementById('umobile').value;
        str = str.substring(0, str.length - 1);
        document.getElementById('umobile').value = str;
    }
}
$('#ufirst_name,#ulast_name').bind("change keyup input", function() {
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


	$('#user_add_validate_js').validate({
		errorClass: 'errors',
			rules: {
            urole:{
                required: true,
            },
            ufirst_name: {
                required: true,
                alpha:true,
                minlength:3,
                maxlength:20
            },
            ulast_name: {
                required: true,
                alpha:true,
                minlength:3,
                maxlength:20
            },
            uemail: {
                required: true,
                email: true,
                email_check: true,
                remote: {
                    url: base_url + 'admin/email_check',
                    type: "post",
                    data: {
                        slug: function() {
                            return $("#uemail").val();
                        }
                    }
                }
            },
            umobile:{
                required: true,
                num_only:true,
                minlength:10,
                maxlength:13
            },
            udob:{
                required: true,
            },
             ugender:{
                required: true,
            },
            ustatus:{
                required: true,
            },

              upassword: {
                required: true,
                pass_match: true,
                minlength: 8,
                maxlength:20
            },
            ucpassword: {
                required: true,
                equalTo: upassword
            },
            'permission[]' :{
                required: true,
            }
           
        },	
        messages: {
            urole:{
                required: "Role field is required",
            },

            ufirst_name: {

                required: "Name field is required",
                alpha: "Enter alpha only"

            },
             ulast_name: {

                required: "Last Name field is required",
                alpha: "Enter alpha only"

            },

            uemail: {
                required: "Email address field is required",
                email_check: 'Enter valid email address',
                 remote: 'Email address is already exists'
            },
            umobile:{
                required: "Mobile field is required",
                num_only:"Phone number must be number only"
            },
            ugender:{
                required: "Gender field is required",
            },
            ustatus:{
                required: "Status field is required",
            },
            upassword: {
                required: "Password field is required",
                pass_match: "*The password does not meet the criteria! <br/>(Password must have atleast 8 characters <br/> 1) Upper letters <br/> 2) Lower letters <br/> 3) Numbers and <br/> 4) Special characters)",
                minlength: "*Your password must be at least 8 characters long"
            },

            ucpassword: {
                required: "confirm password field is required",
                equalTo: "Confirm password not match"
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

$(document).ready(function(){
    $('#urole').change(function(){
//permission_user_load();
 permission_user_load();
    
    });
 permission_user_load();
    

});


  

function permission_user_load(){
    var role_id = $('#urole').val();
        $.ajax({
            url: base_url + 'admin/get_permission_data',
            type:'POST',
            dataType:'JSON',
            data:{role_id:role_id},
            success:function(data){
                
                if(data.status == 1){
                   console.log(data.data);
                
                $('#permission_data_val').html(data.data);
            }else{
                $("#user_permission_show").html(data.msg);
            }
            }
        });

}
