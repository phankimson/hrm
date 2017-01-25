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
                 var tk = [
                     {"id":"code","name":"Mã</br>nhân viên","type":""},
                     {"id":"fullname","name":"Họ và tên</br>nhân viên","type":"total"},
                     {"id":"begin_work_date","name":"Ngày bắt đầu","type":"date"},
                     {"id":"department","name":"Bộ phận","type":""},
                     {"id":"position","name":"Vị trí","type":""},
                     {"id":"salary_probationary","name":"Lương</br>thử việc","type":"number"},
                     {"id":"salary_main","name":"Lương và</br>phụ cấp","type":"number"},
                     {"id":"salary_insurance","name":"Lương</br>bảo hiểm","type":"number"},
                     {"id":"wdp","name":"Công</br>thử việc","type":"decimal"},
                     {"id":"wdps","name":"Tiền công</br>thử việc","type":"number"},
                     {"id":"wd","name":"Ngày</br>công","type":"decimal"},
                     {"id":"wds","name":"Lương</br>theo công","type":"number"},
                     {"id":"wp","name":"Công làm</br>ngày lễ","type":"decimal"},
                     {"id":"wps","name":"Phụ cấp làm</br>ngày lễ","type":"number"},
                     {"id":"ph3","name":"Tăng ca</br>ngày lễ","type":"decimal"},
                     {"id":"ph2","name":"Tăng ca</br>ngày nghỉ","type":"decimal"},
                     {"id":"ph1","name":"Tăng ca</br>ngày thường","type":"decimal"},
                     {"id":"pht","name":"Tổng phụ cấp</br>tăng ca","type":"number"},
                     {"id":"ns","name":"Công</br>ca đêm","type":"number"},
                     {"id":"nss","name":"Phụ cấp</br>ca đêm","type":"number"},
                     {"id":"al","name":"Công</br>phép","type":"number"},
                     {"id":"als","name":"Lương</br>nghỉ phép","type":"number"},
                     {"id":"wc","name":"Công</br>bù","type":"number"},
                     {"id":"wcs","name":"Lương</br>nghỉ bù","type":"number"},
                     {"id":"on_leave_pay","name":"Lương phép năm</br>còn lại","type":"number"},
                     {"id":"telephone_allowance","name":"Phụ cấp</br>điện thoại","type":"number"},
                     {"id":"petrol_allowance","name":"Phụ cấp</br>xăng xe","type":"number"},
                     {"id":"shift_meal_allowance","name":"Phụ cấp</br>ăn ca","type":"number"},
                     {"id":"orther_allowance","name":"Phụ cấp</br>khác","type":"number"},
                     {"id":"total_salary","name":"Tổng thu nhập","type":"number"},
                     {"id":"total_taxable_income","name":"Tổng thu nhập</br>chịu thuế","type":"number"},
                     {"id":"personal_deductions","name":"Giảm trừ</br>bản thân","type":"number"},
                     {"id":"number_dependents","name":"Giảm trừ</br>gia cảnh","type":"number"},
                     {"id":"advanced","name":"Tạm ứng","type":"number"},
                     {"id":"personal_income_tax","name":"Thuế TNCN","type":"number"},
                     {"id":"social_insurance","name":"BHXH","type":"number"},
                     {"id":"health_insurance","name":"BHYT","type":"number"},
                     {"id":"unemployment_insurance","name":"BHTN","type":"number"},
                     {"id":"trade_union_fund","name":"KPCĐ","type":"number"},
                     {"id":"total_deduction","name":"Tổng khấu trừ","type":"number"},
                     {"id":"pay_employee","name":"Phải trả</br>nhân viên","type":"number"},
                     {"id":"service_charge","name":"Phí phục vụ</br>nhân viên","type":"number"}
                 ];
//                 var group = [{"name":"","col":"1"},
//                              {"name":"Nhân viên","col":"2"},
//                              {"name":"Thông tin chung","col":"5"},
//                              {"name":"Công chính","col":"2"},
//                              {"name":"Đi làm ngày lễ","col":"2"},
//                              {"name":"Phụ cấp làm thêm giờ","col":"4"},
//                              {"name":"Ca đêm","col":"2"},
//                              {"name":"Phép","col":"2"},
//                              {"name":"Bù","col":"2"},
//                              {"name":"Phụ cấp","col":"2"},
//                              {"name":"Thu nhập","col":"2"},
//                              {"name":"Giảm trừ","col":"2"},
//                              {"name":"Khấu trừ","col":"7"}
//                              ];
                var ArrayHeaders=[];
                $.each(tk, function(index, item) {
                    ArrayHeaders.push(item.name);
                });
                var ArrayColumn =[];
                $.each(tk, function(index, item) {
                if(item.type=='number'){
                  var columnsList = {   
                   data : item.id,
                   renderer: numberRenderer,
                   readOnly: true,
//                   width : ( 1 * $(window).width() )/item.length
                 };   
                }else if(item.type=='decimal'){
                    var columnsList = {   
                   data : item.id,
                   renderer: decimalRenderer,
                   readOnly: true,
//                   width : ( 1 * $(window).width() )/item.length
                 };  
                }else if(item.type=='date'){
                    var columnsList = {   
                   data : item.id,
                   renderer: dateRenderer,
                   readOnly: true,
//                   width : ( 1 * $(window).width() )/item.length
                 };  
                }else if(item.type=='total'){
                    var columnsList = {   
                   data : item.id,
                   renderer: addTotal,
                   readOnly: true,
//                   width : ( 1 * $(window).width() )/item.length
                 };   
                }else{
                  var columnsList = {   
                   data : item.id,
                   readOnly: true,
//                   width : ( 1 * $(window).width() )/item.length
                 };  
                }                
                    ArrayColumn.push(columnsList);
                });                
                if(hot){
                    hot.destroy();
                }
                hot = new Handsontable(container, {
                  data: data,
                  colHeaders: ArrayHeaders,
                  rowHeaders: true,         
                  minSpareRows: 1,
                  fixedColumnsLeft: 2,
                  fixedColumnsTop: 2,
                  manualColumnFreeze: true,
                  stretchH: 'all',
                  height: ( 1 * $(window).height() ),
//                  contextMenu: true,
                  columns: ArrayColumn
//                   afterRender: function () {
//                 var addgroup = '';
//                     addgroup += '<tr id="header-grouping">';
//                  $.each(group, function(index, item) {
//                     addgroup +='<th colspan="'+item.col+'">'+item.name+'</th>';
//                 });
//                    addgroup += '</tr>';
//                      window.setTimeout(function() {
//                 $('#table-excel').find('thead').find('tr').before(addgroup);
//                   }, 0);
//                    },
//                beforeRender: function() {
//                 while ($('#header-grouping').size() > 0)
//                $('#header-grouping').remove();
//                },
//              afterColumnResize: function () {
//            $container.handsontable('render');
//             },
//               afterGetColHeader: function() {
//            while ($('.ht_clone_top.handsontable #header-grouping th').size() > 0)
//                $('.ht_clone_top.handsontable #header-grouping th').remove();
//        },
//                modifyColWidth: function () {
////           $('#header-grouping').remove();
//             }             
                });
          function dateRenderer(instance, td, row, col, prop, value, cellProperties) {
            var escaped = Handsontable.helper.stringify(value);
            escaped = formatDate(escaped);
            td.innerHTML = escaped;
            return td;
          }
          
          function decimalRenderer(instance, td, row, col, prop, value) {
                      if(row == instance.countRows() - 1){
                        td.style.textAlign = 'right';
                        td.style.fontWeight = 'bold';
                        value = getTotal(prop);
                    }
                     Handsontable.NumericRenderer.apply(this, arguments);
                     var escaped = Handsontable.helper.stringify(value);
                        escaped = formatDecimal(escaped,2);
                        td.innerHTML = escaped;

                        return td;
                  }
           function numberRenderer(instance, td, row, col, prop, value) {
                      if(row == instance.countRows() - 1){
                        td.style.textAlign = 'right';
                        td.style.fontWeight = 'bold';
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