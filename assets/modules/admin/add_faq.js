$(document).ready(function () {
    $("form[name='faq_validate']").validate({
        errorClass: 'errors',
        rules: {
            question: {
                required: true,
            },
            ansfaq:{
                required: true,
            }
        },
        messages: {
            question: {
                required: "Question field is required",
            },
            ansfaq: {
                required: "Answer field is required",
            }
        },
        submitHandler: function (form) {
            form.submit();
        }
    });


});
$(document).ready(function() {
  $('.summernote').summernote({
     height: 150,   //set editable area's height
     codemirror: { // codemirror options
    theme: 'monokai'
  }
  });
});

