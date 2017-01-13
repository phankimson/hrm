var Query = function() {
      var btnStart = function(e){
         e.preventDefault();
        var data = GetAllValueForm('.query-form');
        var postdata = {data : JSON.stringify(data)};  
            RequestURLWaiting('query','json',postdata,function(data){
                if(data.status == true){  
                    jQuery('#notification').EPosMessage('success', data.message); 
                     if(data.data !== true){
                        jQuery.map(data.data[0],function(val,i){
                            jQuery('.table-scrollable thead tr').append('<th>'+i+'</th>');                     
                        });
                           jQuery.map(data.data,function(v,k){
                             jQuery('.table-scrollable tbody').append('<tr></tr>');  
                             jQuery.map(data.data[0],function(val,i){
                             jQuery('.table-scrollable tbody tr:eq('+k+')').append('<td>'+v[i]+'</td>');               
                         });   
                        });
                    } 
                    jQuery('.table-scrollable').removeClass('hidden');
                }else{
                    jQuery('#notification').EPosMessage('error', data.message);
                }      
            },true);  
    };
       var btnClear = function(e){
           jQuery('.table-scrollable').addClass('hidden');
           jQuery('textarea[name="query"]').val('');
       };
       var btnSelect = function(e){
           jQuery('textarea[name="query"]').val('select * from [table]');
       };
       var btnInsert = function(e){
           jQuery('textarea[name="query"]').val('insert into [table] (column1, column2, column3,...) values (value1, value2, value3,...)');
       };
       var btnUpdate = function(e){
           jQuery('textarea[name="query"]').val('UPDATE [table] SET column1=value, column2=value2,... WHERE some_column=some_value ');
       };
       var btnDelete = function(e){
           jQuery('textarea[name="query"]').val('DELETE FROM [table] WHERE some_column = some_value');
       };
       var btnTruncate = function(e){
           jQuery('textarea[name="query"]').val('truncate [table]');  
       }
   
    return {
        //main function to initiate the module
        init: function() {
            jQuery('.start').on('click ', btnStart);
            jQuery('.clear').on('click ', btnClear);
            jQuery('.select').on('click ', btnSelect);
            jQuery('.insert').on('click ', btnInsert);
            jQuery('.update').on('click ', btnUpdate);
            jQuery('.delete').on('click ', btnDelete);
            jQuery('.truncate').on('click ', btnTruncate);
        }

    };

}();

jQuery(document).ready(function() {
    Query.init();
});