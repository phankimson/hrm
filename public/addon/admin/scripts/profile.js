var Profile = function() {

    return {

        //main function
        init: function() {
        
            Profile.initProfileUpdate();
        },

        initProfileUpdate: function() {

            jQuery('.profile-update').validate({
            errorElement: 'span', //default input error message container
            errorClass: 'help-block', // default input error message class
            focusInvalid: false, // do not focus the last invalid input            
            rules: {
                fullname: {
                    required: true
                },
                firstname: {
                    required: true
                },
                lastname: {
                    required: true
                },
                identity_card: {
                    required: true,
                    number  : true
                },
                jobs: {
                    required: true
                },
                about: {
                    required: true
                },
                city: {
                    required: true
                },
                 address: {
                    required: true
                },
                birthday: {
                    required: true
                },
                phone: {
                    required: true,
                    number  : true
                }
            },

            invalidHandler: function(event, validator) { //display error alert on form submit   
                $('.alert-danger', $('.profile-update')).show();
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
                if (element.closest('.control-label').size() === 1) {
                    error.insertAfter(element.closest('.control-label'));
                } else {
                    error.insertAfter(element);
                }
            },

            submitHandler: function(form) {
                form.submit(); // form validation success, call ajax form submit
            }
        });
            
              $('.profile-update').keypress(function(e) {
            if (e.which === 13) {
                if ($('.profile-update').validate().form()) {
                    $('.profile-update').submit(); //form validation success, call ajax form submit
                }
                return false;
            }
                });
                
                
              jQuery('.change-password').validate({
            errorElement: 'span', //default input error message container
            errorClass: 'help-block', // default input error message class
            focusInvalid: false, // do not focus the last invalid input            
            rules: {
                old_password: {
                    required: true,
                    minlength: 6
                },
                new_password: {
                    required: true,
                    minlength: 6
                },
                rnew_password: {
                     equalTo: "#new_password"
                }
                
            },

            invalidHandler: function(event, validator) { //display error alert on form submit   
                $('.alert-danger', $('.change-password')).show();
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
                if (element.closest('.control-label').size() === 1) {
                    error.insertAfter(element.closest('.control-label'));
                } else {
                    error.insertAfter(element);
                }
            },

            submitHandler: function(form) {
                form.submit(); // form validation success, call ajax form submit
            }
        });
         
              $('.change-password').keypress(function(e) {
            if (e.which === 13) {
                if ($('.change-password').validate().form()) {
                    $('.change-password').submit(); //form validation success, call ajax form submit
                }
                return false;
            }
                });          
             //Form PASSWORD  
            jQuery('#cancel-save-password').on('click',function(e){
            e.preventDefault();   
            jQuery('.change-password input').val('');
            });
             
            jQuery('#change-save-password').on('click',function(e){
            e.preventDefault();
              if(jQuery('.change-password').valid()){ 
            var old_password = jQuery('.change-password input[name=old_password]').val();
            var new_password = jQuery('.change-password input[name=new_password]').val();
            var postdata = {data : JSON.stringify({'old_password':old_password,'new_password':new_password})};  
            RequestURLWaiting('update/password','json',postdata,function(data){
                if(data.status == true){  
                        jQuery('#message-password').EPosMessage('success',data.message);
                        setTimeout(function(){ window.location.href = 'index' }, 1500);
                    }else{
                        jQuery('#message-password').EPosMessage('error',data.message);
                    }      
            },true);  
                }
              });  
              
           //Form AVATAR   
            jQuery('#save-avatar').on('click',function(e){
            e.preventDefault(); 
            var a = $('.change-avatar')[0][1];
            var b = a.files[0];
            var fd = new FormData(); // XXX: Neex AJAX2
                fd.append('avatar[]', b);               
          $.ajax({
           url: 'update/avatar',
           xhr: function() { // custom xhr (is the best)
               
           var xhr = new XMLHttpRequest();
           var total = 0;
                        
           // Get the total size of files
           $.each(a.files, function(i, file) {
               total += file.size;
               });

           // Called when upload progress changes. xhr2
           xhr.upload.addEventListener("progress", function(evt) {
           // show progress like example
           var loaded = (evt.loaded / total).toFixed(2)*100; // percent

           $('#progress').text('Uploading... ' + loaded + '%' );
           }, false);
    
            return xhr;
          },
          type: 'post',
          processData: false,
          contentType: false,
          data: fd,
          success: function(results) {
                jQuery('#progress').EPosMessage('success',results.message);
          }
        });
                
              });  
              
            
            var textoption = $('#select2_sample4').attr('select');
            $('#select2_sample4 option').filter(function () { return $(this).html() === textoption; }).prop("selected", true);
            
           
            
            jQuery('#profile-save-changes').on('click', function(e) {
            e.preventDefault();
            if(jQuery('.profile-update').valid()){ 
            var obj = GetAllValueForm('.profile-update');          
              var postdata = {data : JSON.stringify(obj)};  
            RequestURLWaiting('update/profile','json',postdata,function(data){
                if(data.status == true){  
                     jQuery('#message').EPosMessage('success',data.message);
                     jQuery('.form-group').removeClass('has-error');
                }else{
                    jQuery('#notification').EPosMessage('error', data.message);
                }      
            },true);             
             }
        }); 
        }      
      
    };

}();
jQuery(document).ready(function() {
    Profile.init();
});