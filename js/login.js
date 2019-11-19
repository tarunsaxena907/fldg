$(document).ready(function(){
  $("#login-form").validate({
        ignore: [],
        errorClass: 'is-invalid',
        errorPlacement: function (error, element) {
          var errorText = error.text();
          if(element.closest('.form-group').find('.invalid-feedback').length < 1){
            element.closest('.form-group').append('<span class="invalid-feedback">');
          }
          element.closest('.form-group').addClass('has-error');
          element.closest('.form-group').find('.invalid-feedback').html(errorText);
        },
        highlight: function (element, errorClass) {
            $(element).addClass(errorClass).parent().prev().children("select").addClass(errorClass);
            if ($(element).attr('type') == 'radio' || $(element).attr('type') == 'checkbox') {
                $(element).parent().parent().addClass(errorClass);
            }
            if ($(element).attr('name') == 'accept') {
                $(element).next().next().addClass(errorClass);
            }
        },
        rules: {
            loginID: {
              required: true
            },
            loginPassword: {
              required: true
            }
        },
        messages:{
          loginID: {
            required: "Login ID is required field."
          },
          loginPassword: {
            required: "Login password is a required field."
          }
        },
        submitHandler: function (form) {
            form.submit();
        }
    });
});
