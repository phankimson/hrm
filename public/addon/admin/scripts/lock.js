var Lock = function () {
     jQuery('#btn-login-lock').on('click ', function(e) {
        e.preventDefault();
        var name_login = jQuery('.lock-form h4').html();
        var password = jQuery('.lock-form input[name=password]').val();
        var postdata = {data : JSON.stringify({"username":name_login,"password":password})};  
            RequestURLWaiting('login','json',postdata,function(data){
                if(data.status == true){  
                    window.location.href = 'index';
                }else{
                    jQuery('#notification').EPosMessage('error', data.message);
                }      
            },true); 
    });

    return {
        //main function to initiate the module
        init: function () {
        }

    };
      
}();
jQuery(document).ready(function() {
    Lock.init();
});