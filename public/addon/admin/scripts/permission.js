  var Permission = function () {
    var initFilter = function(){
        jQuery('#type').on('change',function(){
          var value =  jQuery(this).val();
            if(value==""){
             jQuery('tr').removeClass('filter').show(1000).find('input').removeClass('filter');    
            }else{
             jQuery('tr').not('.filter-all').addClass('filter').hide(1000).find('input').addClass('filter');      
             jQuery('tr[data-filter="'+value+'"').removeClass('filter').show(1000).find('input').removeClass('filter');    
            }    
           load_checkbox_all();  
        });
    };  
    var group_click = function(e){
         var group = jQuery(this).attr('data-group');
                if(jQuery(this).hasClass('group-hide')){
                jQuery(this).find('i').removeClass('fa-minus').addClass('fa-plus');
                jQuery(this).removeClass('group-hide');                
                jQuery('.item[data-group="'+group+'"]').hide();  
                }else{
                jQuery(this).addClass('group-hide');
                jQuery(this).find('i').removeClass('fa-plus').addClass('fa-minus');
                jQuery('.item[data-group="'+group+'"]').show();     
        }   
    };
    var checkbox_group = function(e){
         var group = jQuery(this).attr('name');
                if(jQuery(this).parent().hasClass('checked')){
                jQuery('input[data-group="'+group+'"]').parent().addClass('checked'); 
                }else{
                jQuery('input[data-group="'+group+'"]').parent().removeClass('checked');   
       }
    };
    var load_checkbox_group = function(e){
                jQuery('.checkbox-group').each(function(e){
                    var name = jQuery(this).attr('name');
                    var i = true ;
                    jQuery('input[data-group="'+name+'"]').each(function(e){
                        if(!jQuery(this).parent().hasClass('checked')){
                           i = false; 
                           return false;
                        }
                    });
                    if(i==true){
                      jQuery(this).parent().addClass('checked');  
                    }else{
                      jQuery(this).parent().removeClass('checked');  
                    }
                });
    }
    var checkbox_all = function(e){
        var group = jQuery(this).attr('name');
                if(jQuery(this).parent().hasClass('checked')){
                jQuery('input[data-group^="'+group+'"]').not('.filter').parent().addClass('checked'); 
                jQuery('input[name^="'+group+'"]').not('.filter').parent().addClass('checked'); 
                }else{
                jQuery('input[data-group^="'+group+'"]').not('.filter').parent().removeClass('checked');   
                jQuery('input[name^="'+group+'"]').not('.filter').parent().removeClass('checked');  
      }  
    };
    var load_checkbox_all = function(e){
                jQuery('.all').each(function(e){
                    var name = jQuery(this).attr('name');
                    var i = true ;
                    jQuery('input[name^="'+name+'"]').not('.filter').not('.all').each(function(e){
                        if(!jQuery(this).parent().hasClass('checked')){
                           i = false; 
                           return false;
                        }
                    });
                    if(i==true){
                      jQuery(this).parent().addClass('checked');  
                    }else{
                      jQuery(this).parent().removeClass('checked');  
                    }
                });
    };
    var change_user = function(e){
       var user = jQuery(this).val();
       if(user == ''){
          jQuery('input[type="checkbox"]').parent().removeClass('checked');
       }else{
        var data =  {data : user};
        RequestURLWaiting('get/permission','json',data,function(data){
                if(data.status == true){                  
//                    jQuery('#notification').EPosMessage('success',data.message);  
                    check_checkbox(data.data);
                    load_id(data.perm);
                    load_checkbox_group();
                    load_checkbox_all();
                }else{
//                    jQuery('#notification').EPosMessage('error', data.message);
                }      
            },true);   
        }
    };
    var check_checkbox = function(data){
        if(data){
             jQuery.each(data,function( key, value) {
             if(value === true){
                 jQuery('input[name="'+key+'"]').parent().addClass('checked');    
             }else{
                 jQuery('input[name="'+key+'"]').parent().removeClass('checked');
             }
        }); 
        }else{
                jQuery('input').parent().removeClass('checked');
        }      
    };
    var load_id = function(data){
       if(data){
         jQuery.each(data,function( key, value) {  
             jQuery('tr[data-id="'+value+'"]').attr('id',key);
           }); 
         }
       } ;
    var btnCancel = function(e){
       var jQuerylink = jQuery(e.target);
         e.preventDefault();
         if(!jQuerylink.data('lockedAt') || +new Date() - jQuerylink.data('lockedAt') > 300) {   
             jQuery('input[type="checkbox"]').parent().removeClass('checked');
             jQuery('#user option:selected').prop("selected", false);
        };
    }   ;
    var btnSave = function(e){
      var jQuerylink = jQuery(e.target);
         e.preventDefault();
         if(!jQuerylink.data('lockedAt') || +new Date() - jQuerylink.data('lockedAt') > 300) {  
        bootbox.confirm("Are you sure?", function(result) {
        if(result==true){
        var user = jQuery('#user').val();
        if(user){
           var aryData = [];       
            jQuery('.table tr').each(function(i, obj) {   
            var id = jQuery(this).attr('id');
            if(!id){
                id = null;
            }
            var menu = jQuery(this).attr('data-id');
            var items = jQuery(this).find('.checkbox-item');
            var action =[];
             jQuery.each(items,function() {
                 var name =  jQuery(this).attr('name').split('-',1)[0];
                    var permission;
                 if(jQuery(this).parent().hasClass('checked')){
                   permission = 1;
                 }else{
                   permission = 0; 
                 }
                 action.push({"name":name,"permission":permission});                       
            }); 
            if(action.length>0){
              aryData.push({"action":action,"menu":menu,"user":user,"id":id});   
            }          
        });
          var data =  {data : JSON.stringify(aryData)};
          RequestURLWaiting('add/permission','json',data,function(data){
                if(data.status == true){                  
                    jQuery('#notification').EPosMessage('success',data.message);
                }else{
                    jQuery('#notification').EPosMessage('error', data.message);
                }      
            },true);  
             }else{
             bootbox.alert(transText["please_input_all_field_require"]);    
           }       
          }
        });
         }
        jQuerylink.data('lockedAt', +new Date());
    };
    var initStatus = function(e){
         jQuery('.group_click').on('click',group_click);
         jQuery('.checkbox-group').on('click',checkbox_group);
         jQuery('.all').on('click',checkbox_all);
         jQuery('.save').on('click',btnSave);
         jQuery('.cancel').on('click',btnCancel);
         jQuery('#user').on('change',change_user);
    };
    return {
        //main function to initiate the module
        init: function () {
           initStatus(); 
           initFilter();
        }
    };
  }();
   jQuery(document).ready(function() {
    Permission.init();
});
