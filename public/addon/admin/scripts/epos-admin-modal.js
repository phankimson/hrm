  var EposAdminModal = function () {  
       var oTable = "";
       var key = 'Ctrl+Alt+';
       var action ; var url;
      var arr = [];var column = [{"mData": "id","position":'0'}];var columndef =[{"bSortable": true,"sClass": "index","aTargets": [ 0 ]}];
     var getColumn = function(){       
           var mData = ''; var mRender ='';var adata = '';
             jQuery('#form-action select').each(function() {
                var k = parseInt(jQuery(this).attr('position')); 
                var a = jQuery(this).attr('id');
                adata ={"type": "select","name" : jQuery(this).attr('name')  ,"id": a,"class": jQuery(this).attr('class')};
                mData = {"mData": jQuery(this).attr('name'),"position":k};
                if(jQuery(this).hasClass('select2me')){
                mRender = { "mRender": function ( data, type, row ) {var text = formatGetValue(data,'#'+a,2);return text ;},"aTargets": [ k ] };
                columndef.push(mRender);
                }
                column.push(mData);    
                arr.push(adata);
            }); 
             jQuery('#form-action textarea').each(function() {
                var k = parseInt(jQuery(this).attr('position')); 
                var a = jQuery(this).attr('id');
                adata ={"type": "textarea","name" : jQuery(this).attr('name')  ,"id": a,"class": jQuery(this).attr('class')};
                mData = {"mData": jQuery(this).attr('name'),"position":k};               
                column.push(mData);    
                arr.push(adata);
            }); 
            jQuery('#form-action .datatable-load').each(function() {
                var $this = this;
                var k = parseInt(jQuery(this).attr('position')); 
                var a = jQuery(this).attr('id');
                if(jQuery(this).hasClass('checkbox-list')){
                adata ={"type": "checkbox","name" : jQuery(this).attr('name')  ,"id": a,"class": jQuery(this).attr('class')};
                mData = {"mData": jQuery(this).attr('name'),"position":k};   
                mRender = { "mRender": function ( data, type, row ) {var text = formatGetValue(data,$this,3);return text ;},"aTargets": [ k ] };   
                columndef.push(mRender);    
                }
                column.push(mData);    
                arr.push(adata);  
            }); 
                  jQuery('#form-action input').not('.checkbox').each(function() {
                var k = parseInt(jQuery(this).attr('position')); 
                if(!jQuery(this).hasClass('hidden')){
                adata ={"type": "input","name" : jQuery(this).attr('name')  ,"id": jQuery(this).attr('id'),"class": jQuery(this).attr('class')};
                }
                mData = {"mData": jQuery(this).attr('name'),"position":k};
                 if(jQuery(this).hasClass('make-switch')){
                mRender = {"mRender": function ( data, type, row ) {var active = formatActive(data);return active ;},"aTargets": [ k ] };
                columndef.push(mRender);
                }else if(jQuery(this).hasClass('image')){
                mRender = {"mRender": function ( data, type, row ) {var a = formatImage(data);return a ;},"aTargets": [ k ] };   
                columndef.push(mRender);
                }else if(jQuery(this).attr('type')=='password'){
                mRender = {"mRender": function ( data, type, row ) {var a = formatSecurity(data);return a ;},"aTargets": [ k ] };   
                columndef.push(mRender);
                }else if(jQuery(this).attr('name')=='created_at' || jQuery(this).attr('name')=='updated_at'|| jQuery(this).hasClass('date-picker')){
                mRender = { "mRender": function ( data, type, row ) {
                    if(data){
                     var date = formatDate(data);
                    return date ;
                  }else{
                    return data;  
                  }
                },
                "aTargets": [ k ]};
                columndef.push(mRender);    
                }else if(jQuery(this).hasClass('number')){
                  mRender = { "mRender": function ( data, type, row ) {
                    if(data){
                     var date = formatNumber(data);
                    return date ;
                  }else{
                    return data;  
                  }                  
                },
                  "aTargets": [ k ]};
                  columndef.push(mRender);    
                }
                column.push(mData); 
                arr.push(adata);
            });
            // Sort by price high to low
                column.sort(sort_by('position', false, parseInt));

            // Sort by city, case-insensitive, A-Z
//            arr.sort(sort_by('city', false, function(a){return a.toUpperCase()}));
            };
      var permission = function(){
          action = EposAdminModal.permission;
          return action;
      };
      var link  = function(){
          url = EposAdminModal.url;
          return url;
      };    
             
      var contentmenu = function() { 
        $('.context-menu').contextmenu({
            target: '#context-menu',
            onItem: function (context, e) {
                var option = $(e.target).attr('data-id');
                //Open View
                if(option == 1){
                  btnAdd(e);
                //Open Order
                }else if(option == 2){
                  btnCopy(e);
                }else if(option == 3){
                  btnEdit(e);
                }else if(option == 4){
                  btnDelete(e);
                }
//                alert($(e.target).attr('data-id')+context.attr('id'));
            }
        });
    };
     var tablemenu = function() { 
        $('.table-menu').contextmenu({
            target: '#table-menu',
            onItem: function (context, e) {
                var option = $(e.target).attr('data-id');
                //Open View
                if(option == 1){
                  btnSave(e);
                //Open Order
                }else if(option == 2){
                  btnCancel(e);
                }
//                alert($(e.target).attr('data-id')+context.attr('id'));
            }
        });
    };
        var initTable = function () {
        var table = jQuery('#grid');

        /*
         * Initialize DataTables, with no sorting on the 'details' column
         */
          oTable = table.DataTable({           
            // Internationalisation. For more info refer to http://datatables.net/manual/i18n
           
            "language": {
                "aria": {
                    "sortAscending": ": activate to sort column ascending",
                    "sortDescending": ": activate to sort column descending"
                },
                "emptyTable": "No data available in table",
                "info": "Showing _START_ to _END_ of _TOTAL_ entries",
                "infoEmpty": "No entries found",
                "infoFiltered": "(filtered1 from _MAX_ total entries)",
                "search": transText["search"],
                "zeroRecords": transText["no_matching_records_found"]
            },          
            "paging":   true,
            "info":     true, 
            "bDestroy": true, 
            "data": EposAdminModal.data,                 
             "aoColumns": column,          
             "aoColumnDefs":  columndef,      
             colReorder: true,
            "order": [
                [0, 'asc']
            ],             
              "createdRow": function( row, data, dataIndex ) {
              jQuery(row).attr( 'id' , data.id);
            },
            "fnDrawCallback": function ( oSettings ) {
               jQuery(".popovers").popover({html : true,content: function() {return jQuery(this).find('.content').html();},container: 'body',placement: 'top'});
                // $("[data-toggle=popover]").popover({ html:true });               
              },
              buttons: [
                { extend: 'print', className: 'btn dark btn-outline' },
                { extend: 'copy', className: 'btn red btn-outline' },
                { extend: 'pdf', className: 'btn green btn-outline' },
                { extend: 'excel', className: 'btn yellow btn-outline ' },
                { extend: 'csv', className: 'btn purple btn-outline ' },
                { extend: 'colvis', className: 'btn dark btn-outline', text: 'Columns'}
            ]
             
        });      
                         
         // handle datatable custom tools
         $('#datatable_ajax_tools > li > a.tool-action').on('click', function() {
            var action = $(this).attr('data-action');
            oTable.button(action).trigger();
        });        
        
        //Index column
        oTable.on( 'order.dt search.dt', function () {
        oTable.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
            cell.innerHTML = i+1;
        } );
    } ).draw();
            
   jQuery("#searchbox-grid").keyup(function() {
        oTable.search( this.value ).draw();
    });                           
     };
       var btnclickgroupitem = function (e) {                
                  if ( jQuery(this).hasClass('active') ) {
                     jQuery(this).removeClass('active');
                     sessionStorage.removeItem('rowid');
                  }
                  else {
                      oTable.$('tr.active').removeClass('active'); 
                      jQuery(this).addClass('active');
                      var data = oTable.row('.active').data();
                      sessionStorage.rowid = data.id;
                        jQuery.each(arr, function(k, v) {      
                            if(v.class.indexOf("select2me")>0 || v.class == 'select2me'){
                                jQuery('#'+v.id).select2('val',data[v.name]);  
                            }else if(v.class.indexOf("make-switch")>0 || v.class == 'make-switch'){
                              var check = data[v.name];
                                    if(check==1){
                                      jQuery('input[name="'+v.name+'"]').bootstrapSwitch('state', true)
                                    }else{
                                      jQuery('input[name="'+v.name+'"]').bootstrapSwitch('state', false);
                                    }  
                            }else if(v.class.indexOf("ckeditor")>0 || v.class == 'ckeditor'){
                                    CKEDITOR.instances[v.name].setData(data[v.name]);
                            }else if(v.class.indexOf("image")>0 || v.class == 'image'){
                                    jQuery('.fileinput-new').find('img').attr('src',App.getHostPath()+data[v.name]);
                            }else if(v.class.indexOf("date-picker")>0 || v.class == 'date-picker'){
                                    jQuery('input[name="'+v.name+'"]').val(formatDate(data[v.name])); 
                            }else if(v.class.indexOf("number")>0 || v.class == 'number'){
                                    jQuery('input[name="'+v.name+'"]').val(data[v.name]); 
                            }else{
                                if(v.type === 'textarea'){
                                 jQuery('textarea[name="'+v.name+'"]').val(data[v.name]);      
                                  }else if(v.type === 'select'){
                                 jQuery('select[name="'+v.name+'"] option:selected').val(data[v.name]);      
                                  }else if(v.type === 'checkbox'){
                                  var arr = jQuery.trim(data[v.name]).split(' ');
                                        jQuery('div[name="'+v.name+'"] .checkbox').parent().removeClass('checked');
                                          for(var i = 0 ; i < arr.length; i++){
                                          jQuery('div[name="'+v.name+'"]').find('.checkbox[value='+arr[i]+']').parent().addClass('checked');
                                          }     
                                  }else{
                                 jQuery('input[name="'+v.name+'"]').val(data[v.name]); 
                                  } 
                            }
                        });   
                  }
              } ;
   var initStatus = function(type){ 
       shortcut.remove(key+"A");
       shortcut.remove(key+"X");
       shortcut.remove(key+"E");
       shortcut.remove(key+"S");
       shortcut.remove(key+"C");
       shortcut.remove(key+"D");
       shortcut.remove(key+"I");
       jQuery('a.add,a.copy,.cancel,a.edit,a.save,a.delete,a.import').off('click'); 
       jQuery('#grid').find('tbody').off( 'click', 'tr', btnclickgroupitem);
       if(type==1){//Default    
       jQuery('.fileinput').fileinput('clear');
       jQuery('tr.active').removeClass('active');   
       jQuery('#grid').find('tbody').on( 'click', 'tr', btnclickgroupitem);    
       shortcut.add(key+"A",function(e) {btnAdd(e);});
       shortcut.add(key+"X",function(e) {btnCopy(e);});
       shortcut.add(key+"E",function(e) {btnEdit(e);});
       shortcut.add(key+"D",function(e) {btnDelete(e);});
       shortcut.add(key+"I",function(e) {btnImport(e);});
       jQuery('.make-switch').not('.config').bootstrapSwitch('state', true);   
       jQuery('#action,#upload,#import').modal('hide');     
       jQuery('#title').text('');
       jQuery('.form-control').not('.config').not('select[name="grid_length"]').val('');
       jQuery('a.add,a.copy,a.import,a.export,a.print,a.edit,a.delete,a.license').removeAttr('disabled');  
       jQuery('a.add').on('click',btnAdd);
       jQuery('a.copy').on('click',btnCopy);
       jQuery('a.edit').on('click',btnEdit);
       jQuery('a.delete').on('click',btnDelete);
       jQuery('a.import').on('click',btnImport);  
       jQuery('a.upload').on('click',btnUpload);  
       jQuery('.form-control').not('.config').not('input[type="search"]').not('select[name="grid_length"]').attr('disabled','');
       jQuery('.cancel,a.save').attr('disabled',''); 
       sessionStorage.removeItem('rowid');
           jQuery.each(arr, function(k, v) {
              if(v.class.indexOf("number")>0 || v.class == 'number'){
                   jQuery('.number').number(true, 0,',','.');
                   return false;
               }
           });
       }else if(type==2){//Add button
          jQuery.each(arr, function(k, v) {      
            if(v.class.indexOf("ckeditor")>0 || v.class == 'ckeditor'){
                CKEDITOR.instances[v.name].setData('');
            }else if(v.class.indexOf("select2me")>0 || v.class == 'select2me'){
                 jQuery('#'+v.id).select2('val','');  
            }else if(v.class.indexOf("number")>0 || v.class == 'number'){
                jQuery('.number').number(true, 0,',','.');
            }
        });  
        shortcut.add(key+"S",function(e) {btnSave(e);});
        shortcut.add(key+"C",function(e) {btnCancel(e);});
        jQuery('.form-control').not('.config').not('select[name="grid_length"]').val('');
        jQuery('#title').html('<i class="icon-pin"></i>'+transText["add"]);
        jQuery('.cancel').on('click',btnCancel);
        jQuery('a.save').on('click',btnSave);
        jQuery('.make-switch').not('.config').bootstrapSwitch('state', true);     
        jQuery('tr.active').removeClass('active');
        jQuery('.form-control').not('.config').removeAttr('disabled');
        jQuery('.bootstrap-switch').removeClass('bootstrap-switch-disabled');        
        jQuery('a.add,a.copy,a.import,a.export,a.print,a.edit,a.delete,a.license').attr('disabled','');
        jQuery('.cancel,a.save').removeAttr('disabled');     
        jQuery('#action').modal('show'); 
       }else if(type==3){//Copy button
        shortcut.add(key+"S",function(e) {btnSave(e);});
        shortcut.add(key+"C",function(e) {btnCancel(e);});
        jQuery('#title').html('<i class="icon-pin"></i>'+transText["copy"]);
        jQuery('.cancel').on('click',btnCancel);
        jQuery('a.save').on('click',btnSave);
        jQuery('tr.active').removeClass('active');
        jQuery('.form-control').not('.config').removeAttr('disabled');
        jQuery('.bootstrap-switch').removeClass('bootstrap-switch-disabled');
        jQuery('a.add,a.copy,a.import,a.export,a.print,a.edit,a.delete,a.license').attr('disabled','');
        jQuery('.cancel,a.save').removeAttr('disabled');  
        jQuery('#action').modal('show'); 
        jQuery('.fileinput-new').find('img').attr('src',App.getHostPath()+'public/global/img/product_image.gif');
       }else if(type==4){//Edit
        shortcut.add(key+"S",function(e) {btnSave(e);});
        shortcut.add(key+"C",function(e) {btnCancel(e);});
        jQuery('#title').html('<i class="icon-pin"></i>'+transText["edit"]);
        jQuery('.cancel').on('click',btnCancel);
        jQuery('a.save').on('click',btnSave);
        jQuery('.form-control').not('.config').removeAttr('disabled');
        jQuery('.bootstrap-switch').removeClass('bootstrap-switch-disabled');
        jQuery('a.add,a.copy,a.import,a.export,a.print,a.edit,a.delete,a.license').attr('disabled','');
        jQuery('.cancel,a.save').removeAttr('disabled');  
        jQuery('#action').modal('show'); 
       }else if(type==5){//Upload
        shortcut.add(key+"C",function(e) {btnCancel(e);});
        jQuery('.cancel').on('click',btnCancel);
        jQuery('.form-control').not('.config').removeAttr('disabled');
        jQuery('a.add,a.copy,a.import,a.export,a.print,a.edit,a.delete,a.license').attr('disabled','');
        jQuery('.cancel').removeAttr('disabled');  
        jQuery('.btn-default').removeAttr('disabled');
        jQuery('#upload').modal('show'); 
       }
   };

   
   
   var btnAdd = function(e){ 
          var jQuerylink = jQuery(e.target);
          e.preventDefault();
         if(!jQuerylink.data('lockedAt') || +new Date() - jQuerylink.data('lockedAt') > 300) {
             if(action['a']==true){   
//         bootbox.confirm(transText["are_you_agree_add"], function(result) {
//        if(result==true){          
          initStatus(2);
          sessionStorage.oper  = 'add';
//            }
//        });
            }else{
          bootbox.alert(transText["you_are_not_permission_add"]);   
         }
         };
        jQuerylink.data('lockedAt', +new Date()); 
        };
        
       var btnUpload = function(e){ 
          var jQuerylink = jQuery(e.target);
          e.preventDefault();
         if(!jQuerylink.data('lockedAt') || +new Date() - jQuerylink.data('lockedAt') > 300) {
               if(action['e']==true){ 
//           bootbox.confirm(transText["are_you_agree_edit"], function(result) {
//          if(result==true){     
          var crit = sessionStorage.rowid;
           if(crit){        
           initStatus(5);
           }else{
          bootbox.alert(transText["you_must_select_product_to_upload"]);        
             }
//            }
//         });
             }else{
            bootbox.alert(transText["you_are_not_permission_edit"]);     
            }
         }
        jQuerylink.data('lockedAt', +new Date()); 
        }; 
   var btnImport = function(e){
         var jQuerylink = jQuery(e.target);
          e.preventDefault();
         if(!jQuerylink.data('lockedAt') || +new Date() - jQuerylink.data('lockedAt') > 300) {
              if(action['a']==true){   
            jQuery('#import').modal('show');
            jQuery('a.saveimport').on('click',btnSaveImport);
//            jQuery('a.download').on('click',btnDownload);
            }else{
            bootbox.alert(transText["you_are_not_permission_add"]);   
            }
         }
        jQuerylink.data('lockedAt', +new Date()); 
        };
   var btnSaveImport = function(e){
       var jQuerylink = jQuery(e.target);
          e.preventDefault();
         if(!jQuerylink.data('lockedAt') || +new Date() - jQuerylink.data('lockedAt') > 300) {
          bootbox.confirm(transText["are_you_agree_save"], function(result) {
         if(result==true){
             EPosUiBlock.show_loading();
          var fd = new FormData(jQuery('.import')[0]); // XXX: Neex AJAX2
        
                // You could show a loading image for example...
    
                 jQuery.ajax({
                   url: url['import_url'],
                   xhr: function() { // custom xhr (is the best)

                   var xhr = new XMLHttpRequest();
                   var total = 0;

                   // Get the total size of files
                   jQuery.each(document.getElementById('file').files, function(i, file) {
                       total += file.size;
                       });

                   // Called when upload progress changes. xhr2
                   xhr.upload.addEventListener("progress", function(evt) {
                   // show progress like example
                   var loaded = (evt.loaded / total).toFixed(2)*100; // percent

                   jQuery('#progress').text('Uploading... ' + loaded + '%' );
                   }, false);

                    return xhr;
                  },
                  type: 'post',
                  processData: false,
                  contentType: false,
                  data: fd,
                  success: function(results) {
                      EPosUiBlock.hide_loading();                    
                       if(results.status==true){
                         bootbox.alert(results.message);
                         jQuery.each(results.data,function(i,item) {
                          oTable.row.add(item[0]).draw();   
                         });
                       }else{
                         bootbox.alert(results.message);
                       } 
                         initStatus(1); 
                  }
                });
            }
          });
         }
        jQuerylink.data('lockedAt', +new Date()); 
        };
//   var btnDownload = function(e){
//         var jQuerylink = jQuery(e.target);
//          e.preventDefault();
//         if(!jQuerylink.data('lockedAt') || +new Date() - jQuerylink.data('lockedAt') > 300) {
//          bootbox.confirm("Bạn có muốn download ?", function(result) {
//         if(result==true){
//           jQuery.ajax({
//                   url: 'export/egoods', 
//                   type: 'post',
//                   success: function(results) {
//                        jQuery('#progress').EPosMessage('success',results.message);
//                  }
//               });
//         };
//     });
//    }
//   };
   var btnCopy = function(e){ 
         var jQuerylink = jQuery(e.target);
         e.preventDefault();
         if(!jQuerylink.data('lockedAt') || +new Date() - jQuerylink.data('lockedAt') > 300) {
             if(action['a']==true){  
//          bootbox.confirm(transText["are_you_agree_copy"], function(result) {
//          if(result==true){     
          var crit = sessionStorage.rowid;
          if(crit){
          initStatus(3); 
           sessionStorage.oper  = 'copy';
            }else{
         bootbox.alert(transText["you_must_select_item_to_copy"]);        
            }
//          }
//        });
            }else{
            bootbox.alert(transText["you_are_not_permission_add"]);           
          } 
         }
        jQuerylink.data('lockedAt', +new Date()); 
        };
      var btnEdit = function(e){ 
          var jQuerylink = jQuery(e.target);
          e.preventDefault();
         if(!jQuerylink.data('lockedAt') || +new Date() - jQuerylink.data('lockedAt') > 300) {
               if(action['e']==true){ 
//           bootbox.confirm(transText["are_you_agree_edit"], function(result) {
//          if(result==true){     
          var crit = sessionStorage.rowid;
           if(crit){        
            initStatus(4); 
             sessionStorage.oper  = 'edit';
           }else{
          bootbox.alert(transText["you_must_select_item_to_edit"]);        
             }
//            }
//         });
             }else{
            bootbox.alert(transText["you_are_not_permission_edit"]);     
            }
         }
        jQuerylink.data('lockedAt', +new Date()); 
        };  
       var btnDelete = function(e){ 
          var jQuerylink = jQuery(e.target);
          e.preventDefault();
         if(!jQuerylink.data('lockedAt') || +new Date() - jQuerylink.data('lockedAt') > 300) {
          if(action['d']==true){   
         var crit = sessionStorage.rowid;
           if(crit){
         bootbox.confirm(transText["are_you_agree_delete"], function(result) {
         if(result==true){
         EPosUiBlock.show_loading();
           var postdata = {'id' : crit};  
                RequestURLWaiting(url['delete_url'],'json',postdata,function(results){
                  if(results.status == false){               
                   bootbox.alert(results.message);
                   }else{
                   bootbox.alert(results.message);
                     oTable.row('.active').remove().draw(); 
                       jQuery.each(arr, function(k, v) {      
                            if(v.class.indexOf("add-option")>0){
                                jQuery('#'+v.id).find('option[value="'+crit+'"]').remove();  
                            }
                        });
                   }
                    initStatus(1); 
                   EPosUiBlock.hide_loading();
            },true);  
            }
          }); 
           }else{
          bootbox.alert(transText["you_must_select_item_to_delete"]);        
          }
           }else{
        bootbox.alert(transText["you_are_not_permission_delete"]);    
        }
         }
        jQuerylink.data('lockedAt', +new Date()); 
        };
      var btnSave = function(e){ 
          var jQuerylink = jQuery(e.target);
          e.preventDefault();
         if(!jQuerylink.data('lockedAt') || +new Date() - jQuerylink.data('lockedAt') > 300) {
           EPosUiBlock.show_loading();
           var obj = {};var b;var a;
           var crit = false;
           obj.oper = sessionStorage.oper;
           obj.id = sessionStorage.rowid;
            jQuery.each(arr, function(k, v) {
                if(v.class.indexOf("not-null")>0&&!jQuery('input[name="'+v.name+'"]').val()){
                    crit = false;
                    return false;
                }else{
                    crit = true;                  
                }
                
                if(v.class.indexOf("select2me")>0){
                    obj[v.name] = jQuery('#'+v.id).select2('val')===""?"0":jQuery('#'+v.id).select2('val');  
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
                }else if(v.class.indexOf("image")>0 || v.class == 'image'){
                            a = jQuery('.change-image')[0][1];                           
                }else if(v.class.indexOf("date")>0 || v.class == 'date'){
                              obj[v.name] = formatDateDefault(jQuery('input[name="'+v.name+'"]').val());                        
                }else{
                   if(v.type=='textarea'){
                   obj[v.name] = jQuery('textarea[name="'+v.name+'"]').val();      
                    }else if(v.type=='select'){
                   obj[v.name] = jQuery('select[name="'+v.name+'"] option:selected').val();      
                    }else if(v.type=='checkbox'){
                        obj[v.name] ='';
                     jQuery('div[name="'+v.name+'"] .checkbox').each(function(){
                    if(jQuery(this).parent().hasClass('checked')){
                      obj[v.name] += jQuery(this).val()+' '; 
                    }
                 });   
                    }else{
                   obj[v.name] = jQuery('input[name="'+v.name+'"]').val(); 
                    }
                }
            });                
           if(crit==true){
               if(jQuery('.change-image') && a){
                    b = a.files[0];    
                 var fd = new FormData(); // XXX: Neex AJAX2
                    fd.append('image', b);  
                    fd.append('data', JSON.stringify(obj)); 
                          jQuery.ajax({
                           url: url['save_url'],                
                           type: "POST",
                           processData: false,
                           contentType: false,
                           data: fd,
                  success: function(data) {
                      if(data.status == true){  
                            if(obj.oper == "add" || obj.oper == "copy"){
                                  oTable.row.add(data.data[0]).draw();
                                  jQuery.each(arr, function(k, v) {      
                                    if(v.class.indexOf("add-option")>0){
                                    jQuery('#'+v.id).append('<option value="'+data.data[0].id+'">'+data.data[0].name+'</option>');
                                     }
                                    });
                            }else{
                                 oTable.row('.active').data(data.data[0]).draw();
                                  oTable.$('tr.active').removeClass('active');
                                  jQuery.each(arr, function(k, v) {      
                                    if(v.class.indexOf("add-option")>0){
                                        jQuery('#'+v.id).find('option[value="'+data.data[0].id+'"]').text(data.data[0].name); 
                                    }
                                });
                            }
                            bootbox.alert(data.message);
                             oTable.page.jumpToData(parseInt(sessionStorage.rowid), 0 );
                            initStatus(1); 

                            EPosUiBlock.hide_loading();
                        }else{
                            bootbox.alert(data.message);
                            EPosUiBlock.hide_loading();
                        }   
                  }                  
                });                    
               }else{
                var postdata = {data : JSON.stringify(obj)};  
                 RequestURLWaiting(url['save_url'],'json',postdata,function(data){
                     if(data.status == true){  
                         if(obj.oper == "add" || obj.oper == "copy"){
                               oTable.row.add(data.data[0]).draw();
                               jQuery.each(arr, function(k, v) {      
                                 if(v.class.indexOf("add-option")>0){
                                 jQuery('#'+v.id).append('<option value="'+data.data[0].id+'">'+data.data[0].name+'</option>');
                                  }
                                 });
                         }else{
                              oTable.row('.active').data(data.data[0]).draw();
                               oTable.$('tr.active').removeClass('active');
                               jQuery.each(arr, function(k, v) {      
                                 if(v.class.indexOf("add-option")>0){
                                     jQuery('#'+v.id).find('option[value="'+data.data[0].id+'"]').text(data.data[0].name); 
                                 }
                             });
                         }
                         bootbox.alert(data.message);
                         initStatus(1); 
                         oTable.page.jumpToData(parseInt(sessionStorage.rowid), 0 );
                         EPosUiBlock.hide_loading();
                     }else{
                         bootbox.alert(data.message);
                     }      
                 },true);    
               }
                      
           }else{
             bootbox.alert(transText["please_input_all_field_require"]);     
              EPosUiBlock.hide_loading();
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
             jQuery.each(arr, function(k, v) {      
                   if(v.class.indexOf("ckeditor")>0 || v.class == 'ckeditor'){
                       CKEDITOR.instances[v.name].setData('');
                   }
               });  
            }
        }); 
         }
        jQuerylink.data('lockedAt', +new Date()); 
        };
    return {
        //main function to initiate the module
        init: function () {
                 link();
                 getColumn();                 
                 initTable(); 
                 initStatus(1);
                 contentmenu();
                 tablemenu();
                 permission(); 
        }
    };
  }();
  
  jQuery(document).ready(function() {
    EposAdminModal.init();
    jQuery(".select2me").select2({ width: 'resolve' });
    //Backdrop z-index fix
      $(document).on('shown.bs.modal', '.modal', function (event) {
            var zIndex = 10010 + (10 * $('.modal,.in').length);
            $(this).css('z-index', zIndex);
            setTimeout(function() {
                $('.modal-backdrop').not('.modal-stack').css('z-index', zIndex - 1).addClass('modal-stack');
            }, 0);
        });

});