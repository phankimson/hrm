var EposAdminMutiTable = function () {
 var oTable = "";  
 var key = 'Ctrl+Alt+';
 var action ; var url; var optionsList;var optionsList1;var optionsList2;
 var handleDateRangePickers = function () {
        var today = moment().format('DD/MM/YYYY');
        if (!jQuery().daterangepicker) {
            return;
        }
         jQuery('#reportrange').daterangepicker({
                opens: (App.isRTL() ? 'right' : 'left'),
                startDate: moment(),
                endDate: moment(),
                minDate: '01/01/2016',
                maxDate: today,
                dateLimit: {
                    days: 60
                },
                showDropdowns: true,
                showWeekNumbers: true,
                timePicker: false,
                timePickerIncrement: 1,
                timePicker12Hour: true,
                ranges: {
                    'Today': [moment(), moment()],
                    'Yesterday': [moment().subtract(1,'days'), moment().subtract(1,'days')],
                    'Last 7 Days': [moment().subtract(6,'days'), moment()],
                    'Last 30 Days': [moment().subtract(29,'days'), moment()],
                    'This Month': [moment().startOf('month'), moment().endOf('month')],
                    'Last Month': [moment().subtract(1,'month').startOf('month'), moment().subtract(1,'month').endOf('month')]
                },
                buttonClasses: ['btn'],
                applyClass: 'green',
                cancelClass: 'default',
                format: 'DD/MM/YYYY',
                separator: ' to ',
                locale: {
                    applyLabel: transText["search"],
                    fromLabel: transText["from"],
                    toLabel: transText["to"],
                    format: 'DD/MM/YYYY',
                    daysOfWeek: ['Su', 'Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa'],
                    monthNames: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
                    firstDay: 1
                }
            },
            function (start, end) {
                jQuery('#reportrange span').html(start.format('DD/MM/YYYY') + ' - ' + end.format('DD/MM/YYYY'));
            }
        );
        //Set the initial state of the picker label
//        jQuery('#reportrange span').html(moment().format('DD/MM/YYYY') + ' - ' + moment().format('DD/MM/YYYY'));
        jQuery('#reportrange').on('hide.daterangepicker', function(ev, picker) {
           var lst_data = {"startDate":picker.startDate.format('YYYY-MM-DD'),"endDate":picker.endDate.format('YYYY-MM-DD')};
            //do something, like clearing an input
//           alert(picker.startDate.format('DD-MM-YYYY')+'-'+picker.endDate.format('DD-MM-YYYY'));
           loadDataTable(lst_data);
          });
        }
  var initHotTable = function (container,header,column,dt) {
                if(dt==null){
                    dt = [];
                }
                var ArrayHeaders= header;
                var ArrayColumn = column;                          
                  jQuery(container).handsontable({
                  data: dt,
                  colHeaders: ArrayHeaders,
                  rowHeaders: true, 
//                  fixedColumnsLeft: 2,
//                  manualColumnFreeze: true,
                  height: ( 0.2 * $(window).height() ),
                  minSpareRows: 1,
                  manualColumnResize: true,
                  manualRowResize: true,
                  columnSorting: true,
                  stretchH: 'all',
                  columns: ArrayColumn,
                    hiddenColumns: {
                    columns: [0],
                    indicators: true
                  },
                   afterChange: function (changes, source) {
                      jQuery('#form-action .total').each(function() {  
                        var name = jQuery(this).attr('name');    
                        var total = jQuery(container).handsontable('getDataAtProp',name);
                        if(total.length>0){
                        var sum = 0; 
                        jQuery.each(total,function(k,v){
                           if(v != null){ 
                           sum += parseInt(v); 
                            }
                        })
                        jQuery(this).val(formatNumber(sum)); 
                        }
                    });
                 },
                 beforeChange:function(changes, source) {
                     var price = 0;
                     var discount = 0;
                     var number_old = 0;
                     var number_new = 0;
                    if(changes[0][1]==='code'){
                    var arr =  jQuery.grep(optionsList, function( a ) {
                       return a.id == parseInt(changes[0][3]);
                     });
                        if(arr.length>0){
                        jQuery('#datatable_detail').find('th').not('.not-show,.hidden').each(function(){
                         var id = jQuery(this).attr('data-id');
                         if(typeof(arr[0][id])!="undefined"){
                         jQuery(container).handsontable('setDataAtRowProp',changes[0][0], id, arr[0][id]);   
                           }else{
                         jQuery(container).handsontable('setDataAtRowProp',changes[0][0], id, '0'); 
                           }
                        }); 
                    }
                   }else if(changes[0][1]==='quantity'&&changes[0][2]!=null){
                     number_old = changes[0][2];  
                     if(number_old ==""){
                        number_old = 0;
                     }
                     number_new = changes[0][3];  
  
                     jQuery.each(column, function(i,obj) {
                        if (obj.data === 'price') {
                             discount = jQuery(container).handsontable('getDataAtRowProp',changes[0][0],'discount'); 
                             price = jQuery(container).handsontable('getDataAtRowProp',changes[0][0],'price');  
                        } else if (obj.data === 'purchase_price'){
                            discount = 0;
                            price = jQuery(container).handsontable('getDataAtRowProp',changes[0][0],'purchase_price');  
                        }
                      });     
                     jQuery(container).handsontable('setDataAtRowProp',changes[0][0], 'discount', number_new*(discount/number_old));  
                     jQuery(container).handsontable('setDataAtRowProp',changes[0][0], 'amount', number_new*(price-discount/number_old)); 
                   }                    
                 },
                 });

            
              //http://fiddle.jshell.net/hU6Kz/2245/light/ sum
                function GreyRowRenderer(instance, td, row, col, prop, value, cellProperties) {
                        Handsontable.renderers.TextRenderer.apply(this, arguments);
                         td.style.background = '#eaeaea';
                        return td;
                      }        
    };
     var ListOption = function(){
          optionsList = EposAdminMutiTable.listoption;
          return optionsList;
      };
       var ListOption1 = function(){
          optionsList1 = EposAdminMutiTable.listoption1;
          return optionsList1;
      };
      var ListOption2 = function(){
          optionsList2 = EposAdminMutiTable.listoption2;
          return optionsList2;
      };
     var loadVoucher = function(e){
         jQuery.post( url['load_url'], function( data ) {
            jQuery('.voucher').val(data.voucher);
          });
     };
     var loadDataTable = function(data){
         jQuery.post( url['load_bill_url'],data, function( result ) {
            EPosUiBlock.show_loading();
            oTable.clear();
            oTable.rows.add(result.data);
            oTable.draw();
            EPosUiBlock.hide_loading();
          });
     };
     
        var getTableExcel = function(){       
             jQuery('.table-excel').each(function(k,v){
                 var header = [];var column =[];
                 jQuery(this).find('.table-load').each(function(){
                     header.push(jQuery(this).html());
                     if(jQuery(this).hasClass('option')){
                        column.push({"data":jQuery(this).attr('data-id'),editor: 'select2',  renderer: customDropdownRenderer, select2Options: { data: optionsList,dropdownAutoWidth: true,width: 'resolve'}}); 
                     }else if(jQuery(this).hasClass('option1')){
                        column.push({"data":jQuery(this).attr('data-id'),editor: 'select2',  renderer: customDropdownRenderer1, select2Options: { data: optionsList1,dropdownAutoWidth: true,width: 'resolve'}}); 
                     }else if(jQuery(this).hasClass('option2')){
                        column.push({"data":jQuery(this).attr('data-id'),editor: 'select2',  renderer: customDropdownRenderer2, select2Options: { data: optionsList2,dropdownAutoWidth: true,width: 'resolve'}}); 
                     }else if(jQuery(this).hasClass('number')){
                        column.push({"data":jQuery(this).attr('data-id'), type: 'numeric', format: '0,0'});  
                     }else{
                        column.push({"data":jQuery(this).attr('data-id')});   
                     }
                   
                 });              
                 var container = document.getElementById(jQuery(this).attr('data-id'));
                 initHotTable(container,header,column,null);
            });
    };
function customDropdownRenderer1(instance, td, row, col, prop, value, cellProperties)
{
    var selectedId;
    for (var index = 0; index < optionsList1.length; index++)
    {
        if (parseInt(value) === optionsList1[index].id)
        {
            selectedId = optionsList1[index].id;
            value = optionsList1[index].text;            
        }
    }
    Handsontable.TextCell.renderer.apply(this, arguments);
    // you can use the selectedId for posting to the DB or server
}    
function customDropdownRenderer2(instance, td, row, col, prop, value, cellProperties)
{
    var selectedId;
    for (var index = 0; index < optionsList2.length; index++)
    {
        if (parseInt(value) === optionsList2[index].id)
        {
            selectedId = optionsList2[index].id;
            value = optionsList2[index].text;            
        }
    }
    Handsontable.TextCell.renderer.apply(this, arguments);
    // you can use the selectedId for posting to the DB or server
}   
    
function customDropdownRenderer(instance, td, row, col, prop, value, cellProperties)
{
    var selectedId;
    for (var index = 0; index < optionsList.length; index++)
    {
        if (parseInt(value) === optionsList[index].id)
        {
            selectedId = optionsList[index].id;
            value = optionsList[index].code;            
        }
    }
    Handsontable.TextCell.renderer.apply(this, arguments);
    // you can use the selectedId for posting to the DB or server
}

     var arr = [];var column = [{"mData": "id","position":'0'}];var columndef =[{"bSortable": true,"sClass": "index","aTargets": [ 0 ]}];
     var getColumn = function(){          
           var mData = ''; var mRender ='';var adata = '';
             jQuery('#form-action select').each(function() {
                var k = parseInt(jQuery(this).attr('position')); 
                var a = jQuery(this).attr('id');
                adata ={"type": "select","name" : jQuery(this).attr('name')  ,"id": a,"class": jQuery(this).attr('class'),"position":k};
                mData = {"mData": jQuery(this).attr('name'),"position":k};
                if(jQuery(this).hasClass('select2me')){
                mRender = { "mRender": function ( data, type, row ) {var text = formatGetValue(data,'#'+a,2);return text ;},"aTargets": [ k ] };
                columndef.push(mRender);
                initSearchSelect2(k,'#filter_'+jQuery(this).attr('name'));
                }
                column.push(mData);    
                arr.push(adata);
            }); 
             jQuery('#form-action textarea').each(function() {
                var k = parseInt(jQuery(this).attr('position')); 
                var a = jQuery(this).attr('id');
                adata ={"type": "textarea","name" : jQuery(this).attr('name')  ,"id": a,"class": jQuery(this).attr('class'),"position":k};
                mData = {"mData": jQuery(this).attr('name'),"position":k};               
                column.push(mData);    
                arr.push(adata);
            }); 
                  jQuery('#form-action input').each(function() {
                var k = parseInt(jQuery(this).attr('position')); 
                adata ={"type": "input","name" : jQuery(this).attr('name')  ,"id": jQuery(this).attr('id'),"class": jQuery(this).attr('class'),"position":k};
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
               initSearchExtRangeDate(k,'#filter_'+jQuery(this).attr('name')+'_from','#filter_'+jQuery(this).attr('name')+'_to')
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
                 initSearchExtRange(k,'#filter_'+jQuery(this).attr('name')+'_from','#filter_'+jQuery(this).attr('name')+'_to');
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
          action = EposAdminMutiTable.permission;
          return action;
      };
      var link  = function(){
          url = EposAdminMutiTable.url;
          return url;
      };   

           var contentmenu = function() { 
        jQuery('.context-menu').contextmenu({
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
    var getFilter = function(){
         jQuery.each(arr,function(k,v){
             if(v.class.indexOf("date-picker")>0 || v.class == 'date-picker'){    
                    jQuery('#filter_'+v.name+'_from', '#filter_'+v.name+'_to').on('picker_event', function() {
                    oTable.draw();
                    } );                         
                }else if(v.class.indexOf("number")>0 || v.class == 'number'){                      
                    jQuery('#filter_'+v.name+'_from', '#filter_'+v.name+'_to').keyup( function() {
                    oTable.draw();
                    } );                      
                }else if(v.class.indexOf("select2")>0 || v.class == 'select2'){
                     jQuery('#filter_'+v.name).on( 'change', function () {
                   oTable.draw();
                } );   
                }else{
                     jQuery('#filter_'+v.name).keyup(  function () {
                    oTable
                        .columns( v.position )
                        .search( this.value )
                        .draw();
                } );      
                        }         
        });
    }
    
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
    var initSearchSelect2 = function(column,elm){
          $.fn.dataTable.ext.search.push(
                    function(oSettings, aData, iDataIndex){
			var value = jQuery(elm).select2('val');			
                        if(value){
			var eval= aData[column];
			var check = jQuery(elm).find('option:contains('+eval+')').val();
			if (value==check) {
				return true;
			}
			else {
				return false;
			}
                    }else{
                        return true;
                    }
		});
        
    }
    
    var initSearchExtRange = function(column,elm_start,elm_end){
           $.fn.dataTable.ext.search.push(
                    function( settings, data, dataIndex ) {
                        var min = parseInt( jQuery(elm_start).val(), 10 );
                        var max = parseInt( jQuery(elm_end).val(), 10 );
                        var age =  data[column].replace(".", "") || 0; // use data for the age column

                        if ( ( isNaN( min ) && isNaN( max ) ) ||
                             ( isNaN( min ) && age <= max ) ||
                             ( min <= age   && isNaN( max ) ) ||
                             ( min <= age   && age <= max ) )
                        {
                            return true;
                        }
                        return false;
                    }
                );
    }
    var initSearchExtRangeDate = function(column,elm_start,elm_end){
         // The plugin function for adding a new filtering routine
                $.fn.dataTable.ext.search.push(
                    function(oSettings, aData, iDataIndex){
			var dateStart = jQuery(elm_start).val();
			var dateEnd =jQuery(elm_end).val();
			// aData represents the table structure as an array of columns, so the script access the date value 
			// in the first column of the table via aData[0]
                        if(dateStart&&dateEnd){
			var evalDate= aData[column];
			
			if (evalDate >= dateStart && evalDate <= dateEnd) {
				return true;
			}
			else {
				return false;
			}
                    }else{
                        return true;
                    }
		});
    }
    
    
    var handleInvoices = function () {

        var grid = jQuery("#grid_total");

        /*
         * Initialize DataTables, with no sorting on the 'details' column
         */
         oTable = grid.DataTable({           
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
            "processing": true,
            "paging":   true,
            "info":     true, 
            "bDestroy": true, 
            "data": EposAdminMutiTable.data, 
            "aoColumns": column,          
            "aoColumnDefs":  columndef,   
            "order": [
                [0, 'asc']
            ],             
              "createdRow": function( row, data, dataIndex ) {
              jQuery(row).attr( 'id' , data.id);
            }, 
        });  
      };
      
       var initStatus = function(type){ 
       shortcut.remove(key+"A");
       shortcut.remove(key+"X");
       shortcut.remove(key+"E");
       shortcut.remove(key+"S");
       shortcut.remove(key+"C");
       shortcut.remove(key+"D");
       jQuery('a.add,a.copy,.cancel,a.edit,a.save,a.delete,a.import').off('click'); 
       jQuery('#grid_total').find('tbody').off( 'click', 'tr', btnclickgroupitem);
       if(type==1){//Default    
       jQuery('.fileinput').fileinput('clear');
       jQuery('tr.active').removeClass('active');   
       jQuery('#grid_total').find('tbody').on( 'click', 'tr', btnclickgroupitem);    
       shortcut.add(key+"A",function(e) {btnAdd(e);});
       shortcut.add(key+"X",function(e) {btnCopy(e);});
       shortcut.add(key+"E",function(e) {btnEdit(e);});
       shortcut.add(key+"D",function(e) {btnDelete(e);});
       jQuery('.make-switch').not('.config').bootstrapSwitch('state', true);   
       jQuery('#action,#upload,#import').modal('hide');     
       jQuery('#title').text('');
       jQuery('.form-control').not('.config').not('select[name="grid_total_length"]').not('.form-filter').val('');
       jQuery('a.add,a.copy,a.import,a.export,a.print,a.edit,a.delete,a.license').removeAttr('disabled');  
       jQuery('a.add').on('click',btnAdd);
       jQuery('a.copy').on('click',btnCopy);
       jQuery('a.edit').on('click',btnEdit);
       jQuery('a.delete').on('click',btnDelete);
       jQuery('.form-control').not('.config').not('input[type="search"]').not('select[name="grid_total_length"]').not('.form-filter').attr('disabled','');
       jQuery('.cancel,a.save').attr('disabled',''); 
       sessionStorage.removeItem('rowid');
       }else if(type==2){//Add button
          jQuery.each(arr, function(k, v) {      
            if(v.class.indexOf("ckeditor")>0 || v.class == 'ckeditor'){
                CKEDITOR.instances[v.name].setData('');
            }else if(v.class.indexOf("select2me")>0 || v.class == 'select2me'){
                 jQuery('#'+v.id).select2('val','');  
            }
        });  
        getTableExcel();
        shortcut.add(key+"S",function(e) {btnSave(e);});
        shortcut.add(key+"C",function(e) {btnCancel(e);});
        jQuery('.form-control').not('.config').not('select[name="grid_total_length"]').not('.form-filter').val('');      
        jQuery('#title').html('<i class="icon-pin"></i>'+transText["add"]);
        jQuery('.cancel').on('click',btnCancel);
        jQuery('a.save').on('click',btnSave);
        jQuery('.make-switch').not('.config').bootstrapSwitch('state', true);     
        jQuery('tr.active').removeClass('active');
        jQuery('.form-control').not('.config').not('.form-filter').not('').removeAttr('disabled');
        jQuery('.bootstrap-switch').removeClass('bootstrap-switch-disabled');        
        jQuery('a.add,a.copy,a.import,a.export,a.print,a.edit,a.delete,a.license').attr('disabled','');
        jQuery('.cancel,a.save').removeAttr('disabled');     
        jQuery('#action').modal('show'); 
        loadVoucher();
         jQuery('.date-picker').val(moment().format('DD/MM/YYYY'));
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
        getTableExcel();
        loadVoucher();
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
                      getTableExcel();
                        jQuery('.handsontable-excel').each(function(k,v){
                            var id = jQuery(this).attr('id');
                            if(id === 'table-excel-detail'){
                            jQuery('#'+id).handsontable('loadData',data.detail);                 
                        }else if(id === 'table-excel-payment'){
                            jQuery('#'+id).handsontable('loadData',data.payment);
                        }
                         });
                      jQuery('#datatable_detail').find('tbody').html('');
                      jQuery('#datatable_credit_memos').find('tbody').html('');
                      jQuery('.name-customer-value').html(data.name);
                      jQuery('.email-customer-value').html(data.email);
                      jQuery('.address-customer-value').html(data.address);
                      jQuery('.phone-customer-value').html(data.phone);
                      jQuery('.username-value').html(data.username);
                      jQuery('.invoice-value').html(data.invoice);
                      jQuery('.shift-value').html(data.shift_name);
                      jQuery('.status-value').html(formatGetValue(data.status,'#status',2));
                      jQuery('.number-value').html(formatNumber(data.number));
                      jQuery('.total-value').html(formatNumber(data.amount));
                      jQuery('.discount-value').html(data.discount); 
                       jQuery.each(data.detail, function(k, v) {
                         if(v.id!=null){
                       jQuery('#datatable_detail').find('tbody').append('<tr><td> <a href="javascript:;"> '+v.code+'</a></td><td> <a href="javascript:;"> '+v.name+'</a></td><td>'+v.unit_name+'</td><td>'+formatNumber(v.price)+'</td><td>'+v.quantity+'</td><td>'+formatNumber(v.discount)+'</td><td>'+formatNumber(v.total)+'</td><td>'+formatGetValue(v.status,'#status-detail',2)+'</td><td>'+formatDate(v.created_at)+'</td></tr>');
                         }
                       });
                       
                       if(data.payment){
                       jQuery.each(data.payment, function(k, v) {  
                          if(v.id!=null){  
                       jQuery('#datatable_credit_memos').find('tbody').append('<tr><td> <a href="javascript:;"> '+v.type+'</a></td><td>'+formatNumber(v.paid)+'</td><td>'+formatNumber(v.return)+'</td><td>'+v.status+'</td><td>'+formatDate(v.created_at)+'</td></tr>');
                           } 
                           });
                       }
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
                                    jQuery('input[name="'+v.name+'"]').val(formatNumber(data[v.name])); 
                            }else{
                                if(v.type === 'textarea'){
                                 jQuery('textarea[name="'+v.name+'"]').val(data[v.name]);      
                                  }else if(v.type === 'select'){
                                 jQuery('select[name="'+v.name+'"] option:selected').val(data[v.name]);      
                                  }else{
                                 jQuery('input[name="'+v.name+'"]').val(data[v.name]); 
                                  } 
                            }
                        });   
                  }
              } ;

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
             jQuery('.handsontable-excel').each(function(k,v){
                      obj['hot'+k] = jQuery(this).handsontable('getSourceData');
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
        
    var initPickers = function () {
        //init date pickers
        jQuery('.date-picker').datepicker({
            rtl: App.isRTL(),
            autoclose: true,
            clearBtn: true,
            todayHighlight: true
        });

        jQuery(".datetime-picker").datetimepicker({
            isRTL: App.isRTL(),
            autoclose: true,
            todayBtn: true,
            pickerPosition: (App.isRTL() ? "bottom-right" : "bottom-left"),
            minuteStep: 10
        });
    }

    return {

        //main function to initiate the module
        init: function () {
            link();   
            getColumn();            
            handleInvoices();
            initStatus(1);
            contentmenu();
            tablemenu();
            permission(); 
            getFilter();  
            ListOption();
            ListOption1();
            ListOption2();   
            initPickers();
            handleDateRangePickers();
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
   EposAdminMutiTable.init();
});