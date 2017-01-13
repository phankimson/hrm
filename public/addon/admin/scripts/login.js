var Login = function() {
    jQuery('input[name="username"],input[name="password"]').keypress(function (e) {
        if (e.which == 13) {
          btnLogin(e);
          return false;    //<---- Add this line
        }
      });
      var btnLogin = function(e){
         e.preventDefault();
        var data = GetAllValueForm('.login-form');
        var postdata = {data : JSON.stringify(data)};  
            RequestURLWaiting('login','json',postdata,function(data){
                if(data.status == true){  
                    window.location.href = 'index';
                }else{
                    jQuery('#notification').EPosMessage('error', data.message);
                }      
            },true);  
    };
      var btnEmail = function(e){
         e.preventDefault();
        var data = GetAllValueForm('.forget-form');
            var postdata = {data : JSON.stringify(data)}; 
            RequestURLWaiting('email/reset','json',postdata,function(data){
                if(data.status == true){  
                    jQuery('#notification').EPosMessage('success', data.message);
                }else{
                    jQuery('#notification').EPosMessage('error', data.message);
                }      
            },true);  
    };   
    var handleLogin = function() {

        $('.login-form').validate({
            errorElement: 'span', //default input error message container
            errorClass: 'help-block', // default input error message class
            focusInvalid: false, // do not focus the last invalid input
            rules: {
                username: {
                    required: true
                },
                password: {
                    required: true
                },
                remember: {
                    required: false
                }
            },

            messages: {
                username: {
                    required: "Username is required."
                },
                password: {
                    required: "Password is required."
                }
            },

            invalidHandler: function(event, validator) { //display error alert on form submit   
                $('.alert-danger', $('.login-form')).show();
            },

            highlight: function(element) { // hightlight error inputs
                $(element)
                    .closest('.form-group').addClass('has-error'); // set error class to the control group
            },

            success: function(label) {
                label.closest('.form-group').removeClass('has-error');
                label.remove();
            },

            errorPlacement: function(error, element) {
                error.insertAfter(element.closest('.input-icon'));
            },

            submitHandler: function(form) {
                form.submit(); // form validation success, call ajax form submit
            }
        });

        $('.login-form input').keypress(function(e) {
            if (e.which == 13) {
                if ($('.login-form').validate().form()) {
                    $('.login-form').submit(); //form validation success, call ajax form submit
                }
                return false;
            }
        });
    }

    var handleForgetPassword = function() {
        $('.forget-form').validate({
            errorElement: 'span', //default input error message container
            errorClass: 'help-block', // default input error message class
            focusInvalid: false, // do not focus the last invalid input
            ignore: "",
            rules: {
                email: {
                    required: true,
                    email: true
                }
            },

            messages: {
                email: {
                    required: "Email is required."
                }
            },

            invalidHandler: function(event, validator) { //display error alert on form submit   

            },

            highlight: function(element) { // hightlight error inputs
                $(element)
                    .closest('.form-group').addClass('has-error'); // set error class to the control group
            },

            success: function(label) {
                label.closest('.form-group').removeClass('has-error');
                label.remove();
            },

            errorPlacement: function(error, element) {
                error.insertAfter(element.closest('.input-icon'));
            },

            submitHandler: function(form) {
                form.submit();
            }
        });

        $('.forget-form input').keypress(function(e) {
            if (e.which == 13) {
                if ($('.forget-form').validate().form()) {
                    $('.forget-form').submit();
                }
                return false;
            }
        });

        jQuery('#forget-password').click(function() {
            jQuery('.login-form').hide();
            jQuery('.forget-form').show();
        });

        jQuery('#back-btn').click(function() {
            jQuery('.login-form').show();
            jQuery('.forget-form').hide();
        });

    };

    return {
        //main function to initiate the module
        init: function() {
            jQuery('#button_login').on('click ', btnLogin);
            jQuery('#button_email').on('click ', btnEmail);
            handleLogin();
            handleForgetPassword();

        }

    };

}();

jQuery(document).ready(function() {
    Login.init();
});