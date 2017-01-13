  var EposReport = function () {  
      var url; var $table = jQuery('#table');  var $table2 = jQuery('#table2');     
      var obj = {};
      var crit = false;
      var initHideShow = function(){
          jQuery('#btn-hide').on('click',function(){
              jQuery('#btn-show').show(1000);
              jQuery('#data-crit').hide(1000);
          });
           jQuery('#btn-show').on('click',function(){
              jQuery('#btn-show').hide(1000);
              jQuery('#data-crit').show(1000);
          });
      };
       var link  = function(){
          url = EposReport.url;
          return url;
      };    
       var arr = [];
       var getColumn = function(){       
            var adata = '';
             jQuery('#data-crit select').each(function() {
                var a = jQuery(this).attr('id');
                adata ={"type": "select","name" : jQuery(this).attr('name')  ,"id": a,"class": jQuery(this).attr('class')};
                arr.push(adata);
            }); 
             jQuery('#data-crit textarea').each(function() {
                var a = jQuery(this).attr('id');
                adata ={"type": "textarea","name" : jQuery(this).attr('name')  ,"id": a,"class": jQuery(this).attr('class')};
                arr.push(adata);
            }); 
                  jQuery('#data-crit input').each(function() {
                if(!jQuery(this).hasClass('hidden')){
                adata ={"type": "input","name" : jQuery(this).attr('name')  ,"id": jQuery(this).attr('id'),"class": jQuery(this).attr('class')};
                }               
                arr.push(adata);
            });
            };
      var initGetValue = function(){            
          jQuery.each(arr, function(k, v) {
                if(v.class.indexOf("not-null")>0&&!jQuery('input[name="'+v.name+'"]').val()){
                    crit = false;
                    return false;
                }else{
                    crit = true;                  
                }
                
                if(v.class.indexOf("select2me")>0){
                    obj[v.name] = jQuery('#'+v.id).select2('val');  
                }else if(v.class.indexOf("make-switch")>0){
                        if(jQuery('input[name="'+v.name+'"]').bootstrapSwitch('state') == true){
                         obj[v.name]  = 1;
                        }else{
                         obj[v.name]  = 0;
                        }  
                }else if(v.class.indexOf("ckeditor")>0 || v.class == 'ckeditor'){
                              obj[v.name] = CKEDITOR.instances[v.name].getData();
                }else if(v.class.indexOf("number")>0 || v.class == 'number'){
                              obj[v.name] = jQuery('input[name="'+v.name+'"]').val().replace(".", "");
                }else if(v.class.indexOf("date-picker")>0 || v.class == 'date-picker'){
                              obj[v.name] = formatDateDefault(jQuery('input[name="'+v.name+'"]').val());
                }else{
                   if(v.type=='textarea'){
                   obj[v.name] = jQuery('textarea[name="'+v.name+'"]').val();      
                    }else if(v.type=='select'){
                   obj[v.name] = jQuery('select[name="'+v.name+'"] option:selected').val();      
                    }else{
                   obj[v.name] = jQuery('input[name="'+v.name+'"]').val(); 
                    }
                }
            }); 
      }
      
      var initSearch = function(e){
            var jQuerylink = jQuery(e.target);
          e.preventDefault();
         if(!jQuerylink.data('lockedAt') || +new Date() - jQuerylink.data('lockedAt') > 300) {
           EPosUiBlock.show_loading();
             initGetValue();
             if(crit==true){
                 var postdata = {data : JSON.stringify(obj)};  
                 RequestURLWaiting(url['search_url'],'json',postdata,function(data){
                     if(data.status == true){ 
                         $table.bootstrapTable('load',data.data);
                         jQuery('#notification').EPosMessage('success',data.message);
                         EPosUiBlock.hide_loading();
                     }else{
                         jQuery('#notification').EPosMessage('error',data.message);
                     }      
                 },true);                   
           }else{
             jQuery('#notification').EPosMessage('error',transText["please_input_all_field_require"]);   
             EPosUiBlock.hide_loading();
           }   
        }
          jQuerylink.data('lockedAt', +new Date()); 
      };
      var initTable = function(){             
             $table.bootstrapTable({
                        data : EposReport.data,
                    });
            jQuery(function () {
                jQuery('#toolbar').find('select').change(function () {
                    $table.bootstrapTable('destroy').bootstrapTable({
                        exportDataType: jQuery(this).val(),
                    });
                });
            });
      };
      var initTable2 = function(){        
            jQuery(function () {
                jQuery('#toolbar').find('select').change(function () {
                    $table2.bootstrapTable('destroy').bootstrapTable({
                        exportDataType: jQuery(this).val(),
                    });
                });
            });
      };
      var initClickTable = function(){
      $table.on('dbl-click-row.bs.table', function (e, row, $element) {
          initGetValue();
          obj['product_id'] = row.id;
         var postdata = {data : JSON.stringify(obj)};  
                 RequestURLWaiting(url['search_detail_url'],'json',postdata,function(data){
                     if(data.status == true){ 
                         $table2.bootstrapTable('load',data.data);
                         jQuery('.nav-tabs a[href="#tab_2"]').tab('show');
                         jQuery('#title').html(data.title);                  
                     }    
                 },true);    
    });
      };
       var handleDatePickers = function () {

        if (jQuery().datepicker) {
            jQuery('.date-picker').datepicker({
                rtl: App.isRTL(),
                orientation: "left",
                autoclose: true,
            });
            //$('body').removeClass("modal-open"); // fix bug when inline picker is used in modal
        }

    };
    
    
    return {
        //main function to initiate the module
        init: function () {            
            getColumn();
            link();
            handleDatePickers();
            initTable();
            initTable2();
            initHideShow();
            initClickTable();
            jQuery('#btn-search').on('click',initSearch);
        }
    };
  }();
  
  jQuery(document).ready(function() {
    jQuery(".select2me").select2({ width: 'resolve' });     
    EposReport.init();
    jQuery('.fixed-table-body').scroll(function(){
        jQuery('.fixed-table-footer').scrollLeft($(this).scrollLeft());
        });
    jQuery('.nav-tabs a').on('shown.bs.tab', function(){
         jQuery('.fixed-table-body').scroll(function(){
        jQuery('.fixed-table-footer').scrollLeft($(this).scrollLeft());
        });
    });
});