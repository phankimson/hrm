var Epos = function () {  
       var key = 'Ctrl+Alt+';
       var hot = '';
       var container = document.getElementById('table-excel');
     var action ;var url; 
      var permission = function(){
          action = Epos.permission;
          return action;
      };
       var link  = function(){
          url = Epos.url;
          return url;
      };   
      var arr = [];
     var getColumn = function(){          
           var adata = '';
             jQuery('#data-crit select').each(function() {
                var k = parseInt(jQuery(this).attr('position')); 
                var a = jQuery(this).attr('id');
                adata ={"type": "select","name" : jQuery(this).attr('name')  ,"id": a,"class": jQuery(this).attr('class'),"position":k};   
                arr.push(adata);
            }); 
             jQuery('#data-crit textarea').each(function() {
                var k = parseInt(jQuery(this).attr('position')); 
                var a = jQuery(this).attr('id');
                adata ={"type": "textarea","name" : jQuery(this).attr('name')  ,"id": a,"class": jQuery(this).attr('class'),"position":k}; 
                arr.push(adata);
            }); 
                jQuery('#data-crit input').each(function() {
                var k = parseInt(jQuery(this).attr('position')); 
                adata ={"type": "input","name" : jQuery(this).attr('name')  ,"id": jQuery(this).attr('id'),"class": jQuery(this).attr('class'),"position":k};      
                arr.push(adata);
            });
       
            }; 
             var initPrint = function (data) {
                 var data = data;
   
                var ArrayHeaders=['Tên nhân viên','Bộ phận','Vị trí','Số tiền'];

                var ArrayColumn =[{data:'fullname',readOnly: true,renderer: addTotal},{data:'department',readOnly: true},{data:'position',readOnly: true},{data:'value',readOnly: true,type:'numeric', renderer: numberRenderer}];
                 
                 function numberRenderer(instance, td, row, col, prop, value) {
                      if(row == instance.countRows() - 1){
                        td.style.textAlign = 'right';
                        value = getTotal(prop);
                    }
                     Handsontable.NumericRenderer.apply(this, arguments);
                     var escaped = Handsontable.helper.stringify(value);
                        escaped = formatNumber(escaped);
                        td.innerHTML = escaped;

                        return td;
                  }
                  
                function addTotal(instance, td, row, col, prop, value){
                    if(row == instance.countRows() - 1){
                    td.style.fontWeight = 'bold';
                    td.style.textAlign = 'right';
                    td.innerText = 'Total: ';
                    return;
                    } else {
                    Handsontable.NumericRenderer.apply(this, arguments);
                    }
                }
            
                function getTotal(prop){
                    var total = 0;
                     data.reduce(function(sum, row){
                        if(row[prop] !==null){
                          total += parseInt(row[prop]);   
                        }     
                    }, 0);
                     return total;
                }  
          
                if(hot){
                    hot.destroy();
                }
                hot = new Handsontable(container, {
                  data: data,
                  colHeaders: ArrayHeaders,
                  rowHeaders: true,         
                  minSpareRows: 1,
                  stretchH: 'all',
//                  contextMenu: true,
                  columns: ArrayColumn
                });
          
    };
       
        var initTable = function (data) {
                 var data = data;
   
                var ArrayHeaders=['Mã nhân viên','Tên nhân viên','Bộ phận','Vị trí','Số giờ làm ngày thường','Số giờ làm ngày nghỉ','Số giờ làm ngày lễ'];

                var ArrayColumn =[{data:'code',readOnly: true,renderer: addTotal},{data:'fullname',readOnly: true},{data:'department',readOnly: true},{data:'position',readOnly: true},{data:'value',type:'numeric',renderer: numberRenderer},{data:'value1',type:'numeric', renderer: numberRenderer},{data:'value2',type:'numeric', renderer: numberRenderer}];
                 
                 function numberRenderer(instance, td, row, col, prop, value) {
                         td.style.textAlign = 'right';
                      if(row == instance.countRows() - 1 ){      
                        value = getTotal(prop);
                    }
                     Handsontable.NumericRenderer.apply(this, arguments);
                     var escaped = Handsontable.helper.stringify(value);
                        escaped = formatNumber(escaped);
                        td.innerHTML = escaped;
                        return td;
                  }
            
                function addTotal(instance, td, row, col, prop, value){
                    if(row == instance.countRows() - 1){
                    td.style.fontWeight = 'bold';
                    td.style.textAlign = 'right';
                    td.innerText = 'Total: ';
                    return;
                    } else {
                    Handsontable.NumericRenderer.apply(this, arguments);
                    }
                }
            
                    function getTotal(prop){
                    var total = 0;
                  data.reduce(function(sum, row){
                        if(row[prop] !==null){
                          total += parseFloat(row[prop]);   
                        }     
                    }, 0);
                     return total;
                }  
          
                if(hot){
                    hot.destroy();
                }
                hot = new Handsontable(container, {
                  data: data,
                  colHeaders: ArrayHeaders,
                  rowHeaders: true,         
                  minSpareRows: 1,
                  height: ( 1 * $(window).height() ),
                  fixedColumnsLeft: 2,
                  manualColumnFreeze: true,
                  manualColumnResize: true,
                  manualRowResize: true,
                  columnSorting: true,
                   stretchH: 'all',
//                  contextMenu: true,
                  columns: ArrayColumn
 
                });
          
    };

   var initStatus = function(type){ 
       shortcut.remove(key+"A");
       shortcut.remove(key+"E");
       shortcut.remove(key+"D");
       shortcut.remove(key+"S");
       shortcut.remove(key+"C");
       shortcut.remove(key+"P");
       jQuery('a.add,a.find,a.cancel,a.edit,a.save,a.delete,a.print').off('click');
       jQuery('.select2-multiple').select2();
      if(type==1){//Default
       jQuery('a.cancel,a.save').attr('disabled',''); 
       jQuery('a.add,a.find,a.edit,a.delete,a.print,a.total').removeAttr('disabled');
       jQuery('#table-excel').css('display','none');
       jQuery('.form-control').removeAttr('disabled');
       shortcut.add(key+"A",function(e) {btnAdd(e);});
       shortcut.add(key+"E",function(e) {btnEdit(e);});
       shortcut.add(key+"D",function(e) {btnDelete(e);});  
       shortcut.add(key+"P",function(e) {btnPrint(e);});   
       jQuery('a.add').on('click',btnAdd);
       jQuery('a.edit').on('click',btnEdit);
       jQuery('a.delete').on('click',btnDelete);
       jQuery('a.print').on('click',btnPrint);
//       jQuery('a.export').on('click',btnExport);
       }else if(type==2){//Add,Edit button
        jQuery('a.cancel,a.save').removeAttr('disabled');
        jQuery('a.add,a.find,a.edit,a.delete,a.print').attr('disabled','');
        jQuery('.form-control').attr('disabled','');
        shortcut.add(key+"S",function(e) {btnSave(e);});
        shortcut.add(key+"C",function(e) {btnCancel(e);});
        jQuery('a.cancel').on('click',btnCancel);
        jQuery('a.save').on('click',btnSave);
        jQuery('#table-excel').css('display','block');
       }
   };
   var btnAdd = function(e){ 
          var jQuerylink = jQuery(e.target);
          e.preventDefault();
         if(!jQuerylink.data('lockedAt') || +new Date() - jQuerylink.data('lockedAt') > 300) {
           if(action['a']==true){   
        var obj = {};
           var crit = false;
           obj.oper = 'add';
            jQuery.each(arr, function(k, v) { 
                if (v.class.indexOf("select2-check")>0&&jQuery('#'+v.id+'').select2('val')==""){                   
                    crit = false;
                    return false;
                }else if(v.class.indexOf("not-null")>0&&!jQuery('input[name="'+v.name+'"]').val()){
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
                }else if(v.class.indexOf("date")>0 || v.class == 'date'){
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
          if(crit==true){
              var postdata = {data : JSON.stringify(obj)};  
            RequestURLWaiting(url['load_url'],'json',postdata,function(data){
                if(data.status == true){
                    jQuery('#notification').EPosMessage('success',data.message);
                    initStatus(2);
                    initTable(data.data,data.tk,data.pd);
                }else{
                    jQuery('#notification').EPosMessage('error', data.message);
                }      
            },true);
          }else{
             jQuery('#notification').EPosMessage('error', transText["please_input_all_field_require"] );
          }
          }else{
              bootbox.alert(transText["you_are_not_permission_add"]);   
             }
         };
        jQuerylink.data('lockedAt', +new Date()); 
        };
        var btnTotal = function(e){ 
          var jQuerylink = jQuery(e.target);
          e.preventDefault();
         if(!jQuerylink.data('lockedAt') || +new Date() - jQuerylink.data('lockedAt') > 300) {
         var obj = {};
           var crit = false;
           obj.oper = 'total';
            jQuery.each(arr, function(k, v) { 
                if (v.class.indexOf("select2-check")>0&&jQuery('#'+v.id+'').select2('val')==""){                   
                    crit = false;
                    return false;
                }else if(v.class.indexOf("not-null")>0&&!jQuery('input[name="'+v.name+'"]').val()){
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
                }else if(v.class.indexOf("date")>0 || v.class == 'date'){
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
          if(crit==true){
              var postdata = {data : JSON.stringify(obj)};  
            RequestURLWaiting(url['load_url'],'json',postdata,function(data){
                if(data.status == true){
                    jQuery('#notification').EPosMessage('success',data.message);
                    jQuery('#table-excel').css('display','block');
                    initTotal(data.data,data.tk);
                }else{
                    jQuery('#notification').EPosMessage('error', data.message);
                }      
            },true);
          }else{
             jQuery('#notification').EPosMessage('error', transText["please_input_all_field_require"] );
          }          
         };
        jQuerylink.data('lockedAt', +new Date()); 
        };    

      var btnEdit = function(e){ 
         var jQuerylink = jQuery(e.target);
          e.preventDefault();
         if(!jQuerylink.data('lockedAt') || +new Date() - jQuerylink.data('lockedAt') > 300) {
              if(action['e']==true){
           var obj = {};
           var crit = false;
           obj.oper = 'edit';
            jQuery.each(arr, function(k, v) { 
                if (v.class.indexOf("select2-check")>0&&jQuery('#'+v.id+'').select2('val')==""){                   
                    crit = false;
                    return false;
                }else if(v.class.indexOf("not-null")>0&&!jQuery('input[name="'+v.name+'"]').val()){
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
                }else if(v.class.indexOf("date")>0 || v.class == 'date'){
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
          if(crit==true){
              var postdata = {data : JSON.stringify(obj)};  
            RequestURLWaiting(url['load_url'],'json',postdata,function(data){
                if(data.status == true){
                    jQuery('#notification').EPosMessage('success',data.message);
                    initStatus(2);
                    initTable(data.data,data.tk,data.pd);
                }else{
                    jQuery('#notification').EPosMessage('error', data.message);
                }      
            },true);
          }else{
             jQuery('#notification').EPosMessage('error', transText["please_input_all_field_require"] );
          }
           }else{
            bootbox.alert(transText["you_are_not_permission_edit"]);     
            }
         };
        jQuerylink.data('lockedAt', +new Date()); 
        };  
       var btnDelete = function(e){ 
         var jQuerylink = jQuery(e.target);
          e.preventDefault();
         if(!jQuerylink.data('lockedAt') || +new Date() - jQuerylink.data('lockedAt') > 300) {
           if(action['d']==true){
               var obj = {};
               var crit = false;
               obj.oper = 'edit';
               jQuery.each(arr, function(k, v) {
                   if (v.class.indexOf("select2-check")>0&&jQuery('#'+v.id+'').select2('val')==""){
                       crit = false;
                       return false;
                   }else if(v.class.indexOf("not-null")>0&&!jQuery('input[name="'+v.name+'"]').val()){
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
                   }else if(v.class.indexOf("date")>0 || v.class == 'date'){
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
               if(crit==true){
                   var postdata = {data : JSON.stringify(obj)};
                   RequestURLWaiting(url['delete_url'],'json',postdata,function(data){
                if(data.status == true){
                    jQuery('#notification').EPosMessage('success',data.message);
                }else{
                    jQuery('#notification').EPosMessage('error', data.message);
                }      
            },true);
          }else{
             jQuery('#notification').EPosMessage('error', transText["please_input_all_field_require"] );
          } 
           }else{
           bootbox.alert(transText["you_are_not_permission_delete"]);    
         }
         };
        jQuerylink.data('lockedAt', +new Date()); 
        };
      var btnSave = function(e){ 
          var jQuerylink = jQuery(e.target);
          e.preventDefault();
         if(!jQuerylink.data('lockedAt') || +new Date() - jQuerylink.data('lockedAt') > 300) {
           var obj = {};
           obj.oper = 'save';
            jQuery.each(arr, function(k, v) {            
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
                }else if(v.class.indexOf("date")>0 || v.class == 'date'){
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
               obj.hot = hot.getSourceData();
              var postdata = {data : JSON.stringify(obj)};  
              if(postdata){
             RequestURLWaiting(url['save_url'],'json',postdata,function(data){
                if(data.status == true){
                    jQuery('#notification').EPosMessage('success',data.message);
                    initStatus(1);
                }else{
                    jQuery('#notification').EPosMessage('error', data.message);
                }      
            },true);            
           }else{
             bootbox.alert(transText["please_input_all_field_require"]);     
           }                                    
         }
        jQuerylink.data('lockedAt', +new Date()); 
        };
   var btnCancel = function(e){ 
          var jQuerylink = jQuery(e.target);
          e.preventDefault();
         if(!jQuerylink.data('lockedAt') || +new Date() - jQuerylink.data('lockedAt') > 300) {
        bootbox.confirm(transText["are_you_agree_cancel"], function(result) {
        if(result==true){          
          initStatus(1);
            }
        }); 
         }
        jQuerylink.data('lockedAt', +new Date()); 
        };
    var btnPrint = function(e){ 
           var jQuerylink = jQuery(e.target);
          e.preventDefault();
         if(!jQuerylink.data('lockedAt') || +new Date() - jQuerylink.data('lockedAt') > 300) {
            var obj = {};
           var crit = false;
           obj.oper = 'edit';
            jQuery.each(arr, function(k, v) { 
                if (v.class.indexOf("select2-check")>0&&jQuery('#'+v.id+'').select2('val')==""){                   
                    crit = false;
                    return false;
                }else if(v.class.indexOf("not-null")>0&&!jQuery('input[name="'+v.name+'"]').val()){
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
                }else if(v.class.indexOf("date")>0 || v.class == 'date'){
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
          if(crit){
              var postdata = {data : JSON.stringify(obj)};  
            RequestURLWaiting(url['load_url'],'json',postdata,function(data){
                if(data.status == true){
                    jQuery('#notification').EPosMessage('success',data.message);   
                    jQuery('#table-excel').removeAttr('style');
                    initPrint(data.data,data.pd);
                    jQuery('#table-excel').print();
                    jQuery('#table-excel').css({'width':'100%','overflow':'auto','display':'none'});
                }else{
                    jQuery('#notification').EPosMessage('error', data.message);
                }      
            },true);
          }else{
             jQuery('#notification').EPosMessage('error', transText["please_input_all_field_require"] );
          }          
         };
        jQuerylink.data('lockedAt', +new Date()); 
        };  
   
    return {
        //main function to initiate the module
        init: function () {
                 initStatus(1);
                 getColumn();
                 link();
                 permission();
        }
    };
  }();
   jQuery(document).ready(function() {    
   jQuery(".select2me").select2({ width: 'resolve',placeholder: "" });
    //Backdrop z-index fix
      jQuery(document).on('shown.bs.modal', '.modal', function (event) {
            var zIndex = 10010 + (10 * $('.modal,.in').length);
            jQuery(this).css('z-index', zIndex);
            setTimeout(function() {
                jQuery('.modal-backdrop').not('.modal-stack').css('z-index', zIndex - 1).addClass('modal-stack');
            }, 0);   
             jQuery('.handsontable-excel').each(function(k,v){
                var id = jQuery(this).attr('id');
              setTimeout(function() {
                    jQuery("#"+id).handsontable('render');
                    }, 0);
               });
        });
   Epos.init();
});