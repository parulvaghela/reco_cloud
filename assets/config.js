/********************** Function ***********************/
//Number Digit
function isNumber(evt){
	evt = (evt) ? evt : window.event;
	var charCode = (evt.which) ? evt.which : evt.keyCode;
	if (charCode > 31 && (charCode < 48 || charCode > 57)) {
		return false;
	}
	return true;
}
function decimal_digit(evt){
	evt = (evt) ? evt : window.event;
	var charCode = (evt.which) ? evt.which : evt.keyCode;
	if(charCode > 31 && (charCode < 48 || charCode > 57) && (charCode != 46)){
		return false;
	}
	return true;
}
function isalpha(evt)
{
 var keyCode = (evt.which) ? evt.which : evt.keyCode
 if ((keyCode < 65 || keyCode > 90) && (keyCode < 97 || keyCode > 123) && keyCode != 32)
  {
    return false;
  }
  return true;
}  

$(document).on('click', '.toggle-password', function() {
   // var input = $(".password");
    var id = $(this).attr('data-id');
    var input = $('#'+id);
    var value = input.val();
    if(value.length  > 0)
    {
      $(this).toggleClass("fa-eye fa-eye-slash");
      input.attr('type') === 'password' ? input.attr('type','text') : input.attr('type','password')
    }  
});

/********************** End Function ***********************/