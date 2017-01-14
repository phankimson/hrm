var EposHand = function () {  
       var key = 'Ctrl+Alt+';
       var hot = '';
       var container = document.getElementById('table-excel');
     var action ;var url; 
      var permission = function(){
          action = EposHand.permission;
          return action;
      };
       var link  = function(){
          url = EposHand.url;
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
        var initPrint = function (data,date) {
                 var data = data;
                 var split = date.split('/');
                 var month = split[0];
                 var year = split[1];
//               function customDropdownRenderer(instance, td, row, col, prop, value, cellProperties)
//                {
//                    var selectedId;
//                    for (var index = 0; index < optionsList.length; index++)
//                    {
//                        if (parseInt(value) === optionsList[index].id)
//                        {
//                            selectedId = optionsList[index].id;
//                            value = optionsList[index].text;            
//                        }
//                    }
//                    Handsontable.TextCell.renderer.apply(this, arguments);
//                    // you can use the selectedId for posting to the DB or server
//                }
                               
                var ArrayHeaders=['Tên nhân viên'];
                for(var i = 1; i<=daysInMonth(month,year);i++){
                    ArrayHeaders.push(i);
                };
                var ArrayColumn =[{data:'fullname',readOnly: true,width : ( 0.15 * $(window).width() )}];
                for(var i = 1; i<=daysInMonth(month,year);i++){
                   var columnsList = {   
                   data : i,
                   readOnly: true,
                   width :  ($(window).width() - ( 0.5 * $(window).width() )) /daysInMonth(month,year)
                 };
                    ArrayColumn.push(columnsList);
                }; 
                if(hot){
                    hot.destroy();
                }
                hot = new Handsontable(container, {
                  data: data,
                  colHeaders: ArrayHeaders,       
                  minSpareRows: 0,
                   stretchH: 'all',
//                  contextMenu: true,
                  columns: ArrayColumn
                });
    };
        var initTotal = function (data,tk) {
                 var data = data;    
                var ArrayHeaders=['Mã nhân viên','Tên nhân viên'];
                $.each(tk, function(index, item) {
                    ArrayHeaders.push(item.code);
                });
                var ArrayColumn =[{data:'code',readOnly: true,width : ( 0.1 * $(window).width() )},{data:'fullname',readOnly: true,width : ( 0.1 * $(window).width() )}];
                $.each(tk, function(index, item) {
                    var columnsList = {   
                   data : item.code,
                   readOnly: true,
                   width : ( 1 * $(window).width() )/item.length
                 };
                    ArrayColumn.push(columnsList);
                });                
                if(hot){
                    hot.destroy();
                }
                hot = new Handsontable(container, {
                  data: data,
                  colHeaders: ArrayHeaders,
                  rowHeaders: true,         
                  minSpareRows: 0,
                  height: ( 1 * $(window).height() ),
                  nativeScrollbars: true,
                   stretchH: 'all',
//                  contextMenu: true,
                  columns: ArrayColumn
                });
          
    };
        var initTable = function (data,timekeeper,date) {
                 var data = data;
                 var optionsList = timekeeper;
                 var split = date.split('/');
                 var month = split[0];
                 var year = split[1];
               function customDropdownRenderer(instance, td, row, col, prop, value, cellProperties)
                {
                          var selectedId;
                            for (var index = 0; index < optionsList.length; index++)
                            {
                                if (value === ','+optionsList[index].id)
                                {
                                    selectedId = optionsList[index].id;
                                    value = optionsList[index].id; 
                                    break;
                                }else if(value != null && value != optionsList[index].id){
                                   value = value.replace(/,/i,"");
                                   break;
                                }
                            }
                    Handsontable.TextCell.renderer.apply(this, arguments);
                    // you can use the selectedId for posting to the DB or server
                }
                               
                var ArrayHeaders=['Mã nhân viên','Tên nhân viên','Bộ phận','Vị trí'];
                var header;
                for(var i = 1; i<=daysInMonth(month,year);i++){
                    var d = new Date(year+'-'+month+'-'+i);
                    header = getWeekDay(d);
                    ArrayHeaders.push(i+' '+header);
                };
                var ArrayColumn =[{data:'code',readOnly: true},{data:'fullname',readOnly: true},{data:'department',readOnly: true},{data:'position',readOnly: true}];
                for(var i = 1; i<=daysInMonth(month,year);i++){
                   var columnsList = {   
                   data : i,
                   editor: 'select2',
                   renderer: customDropdownRenderer,
                    select2Options: { // these options are the select2 initialization options 
                        data: optionsList,
                        dropdownAutoWidth: true,
                        multiple : true,
                        allowClear: true,
                        width: jQuery(window).width()*0.2
                    }
                 };
                    ArrayColumn.push(columnsList);
                };
                 function GreenRowRenderer(instance, td, row, col, prop, value, cellProperties) {
                        Handsontable.renderers.TextRenderer.apply(this, arguments);
                        td.style.fontWeight = 'bold';
                        td.style.color = 'green';
                        td.style.background = '#CEC';
                           var selectedId;
                            for (var index = 0; index < optionsList.length; index++)
                            {
                                if (value === ','+optionsList[index].id)
                                {
                                    selectedId = optionsList[index].id;
                                    value = optionsList[index].id; 
                                    break;
                                }else if(value != null && value != optionsList[index].id){
                                   value = value.replace(/,/i,"");
                                   break;
                                }
                            }
                    Handsontable.TextCell.renderer.apply(this, arguments);
                    // you can use the selectedId for posting to the DB or server
                      }  
                if(hot){
                    hot.destroy();
                }
                hot = new Handsontable(container, {
                  data: data,
                  colHeaders: ArrayHeaders,
                  rowHeaders: true, 
                  fixedColumnsLeft: 2,
                  manualColumnFreeze: true,
                  height: ( 1 * $(window).height() ),
                  minSpareRows: 0,
                  manualColumnResize: true,
                  manualRowResize: true,
                  columnSorting: true,
                  stretchH: 'all',
                  columns: ArrayColumn,
                   cells: function (row, col, prop) {
                           var cellProperties = {};
                           var d = new Date(year+'-'+month+'-'+prop);
                           header = getWeekDay(d);
                           if(header=='Sun'){
                            cellProperties.renderer = GreenRowRenderer;   
                           }
                           return cellProperties;
                        }
                });
          
    };

   var initStatus = function(type){ 
       shortcut.remove(key+"A");
       shortcut.remove(key+"E");
       shortcut.remove(key+"D");
       shortcut.remove(key+"S");
       shortcut.remove(key+"C");
       shortcut.remove(key+"P");
       shortcut.remove(key+"T");
       jQuery('a.add,a.find,a.cancel,a.edit,a.save,a.delete,a.print,a.total,a.saveovertime').off('click');
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
       shortcut.add(key+"T",function(e) {btnTotal(e);}); 
       jQuery('a.add').on('click',btnAdd);
       jQuery('a.edit').on('click',btnEdit);
       jQuery('a.delete').on('click',btnDelete);
       jQuery('a.print').on('click',btnPrint);
       jQuery('a.total').on('click',btnTotal);
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
                              obj[v.name] = jQuery('input[name="'+v.name+'"]').val();
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
                              obj[v.name] = jQuery('input[name="'+v.name+'"]').val();
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
                   RequestURLWaiting('update/timesheet','json',postdata,function(data){
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
                }else if(v.class.indexOf("number")>0 || v.class == 'number'){
                              obj[v.name] = jQuery('input[name="'+v.name+'"]').val().replace(".", "");
                }else if(v.class.indexOf("image")>0 || v.class == 'image'){
                            a = jQuery('.change-image')[0][1];                           
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
   EposHand.init();
});