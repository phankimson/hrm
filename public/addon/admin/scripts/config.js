var Config = function () { 
    var btnContact = function(e){
         var $link = $(e.target);
          e.preventDefault();
         if(!$link.data('lockedAt') || +new Date() - $link.data('lockedAt') > 300) {
         var obj = GetAllValue('#config-form');
        if(obj){
        var postdata = {data : JSON.stringify(obj)};  
            RequestURLWaiting('update/config','json',postdata,function(data){
                if(data.status == true){
                    jQuery('#config').modal('hide');
                    bootbox.alert(data.message);
                }else{
                    bootbox.alert(data.message);
                }      
            },true);  
        }else{
             bootbox.alert(transText["please_input_all_field_require"]);
        }  
        }
        $link.data('lockedAt', +new Date()); 
    };   
    return {
        //main function to initiate the module
        init: function () {			
           jQuery('#save-config').on('click', btnContact);
        }
    };

}();
   jQuery(document).ready(function() {
        Config.init(); // init metronic core componets
    });
