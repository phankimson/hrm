var Main = function () {
    var url;
        var initPickers = function () {
        //init date pickers
        jQuery('.date-picker').datepicker({
            rtl: App.isRTL(),
            autoclose: true,
            clearBtn: true,
            todayHighlight: true
        });
     
    };    
    
      var link  = function(){
          url = Main.url;
          return url;
      };  
     var Total = function(){
        var total_quantity = 0;
        var total_amount = 0;
        jQuery('#table-return').find('.touchspin').each(function(){
           total_quantity += parseInt(jQuery(this).val());
        });
        jQuery('#table-return').find('.amount').each(function(){
           total_amount += parseInt(jQuery(this).text().replace(".",""));
        });
        jQuery('#table-return').find('.total-quantity').text(total_quantity);
        jQuery('#table-return').find('.total-amount').text(formatNumber(total_amount));
    };   
    var initSaveReturnBill = function(){
        jQuery('.payment').on('click',function(){
       var data = {}; var detail = [];
           data['invoice'] = jQuery('#invoice').text().trim();
//           data['date_invoice'] = jQuery('input[name="date_invoice"]').text().trim();
           data['note'] = jQuery('area[name="note"]').text().trim();
       jQuery('#table-return tbody').find('tr').not('.tr-copy').each(function(k,v){
           if(jQuery(this).find('.touchspin').val()>0){
               var aData = {"id":jQuery(this).attr('data-id'),"quantity":jQuery(this).find('.touchspin').val()};
                detail.push(aData);
            }
        });
         data['detail'] = detail;
       var postdata = {data :JSON.stringify(data)};
            RequestURLWaiting(url['return_url'],'json',postdata,function(data){
             if(data.status == 'comfirm'){
              bootbox.confirm({
                title: 'Thông báo',
                message: data.message,
                buttons: {                   
                    'confirm': {
                        label: 'Quay lại đăng nhập',
                        className: 'btn-danger pull-right'
                    }
                },
                callback: function(result) {
                    if (result) {
                        window.location.href = 'logout';
                    }
                }
            }); 
           }else if(data.status == true){  
                jQuery('#table-return tbody').find('tr').not('.tr-copy').remove();  
                jQuery('.touchspin').val(0);
                Total();
                 bootbox.alert({title: 'Thông báo',message: data.message,className: "alert"});    
                }else{
                 bootbox.alert({title: 'Thông báo',message: data.message,className: "alert"});    
                }      
            },true);  
         });  
     };
     
     var initCancelBill = function(){
          jQuery('.cancel-bill').on('change',function(){
         jQuery('#table-return tbody').find('tr').not('.tr-copy').remove();  
        jQuery('.touchspin').val(0);
        Total();
        });
     }
    
    var initSearchBill = function(){
        jQuery('#search_bill').on('change',function(){
            var data = jQuery(this).val().trim();
            var postdata = {data : data};  
            RequestURLWaiting(url['search_url'],'json',postdata,function(data){
                if(data.data){  
                    jQuery('#invoice').text(data.data.invoice);
                    jQuery('#customer').text(data.data.partner_name);
                    jQuery('#total_number').text(data.data.quantity);
                    var discount = (data.data.discount === null) ? 0 : data.data.discount;
                    jQuery('#total_discount').text(discount);
                    jQuery('#total_amount').text(formatNumber(data.data.amount));
                    jQuery('#table-return tbody').find('tr').not('.tr-copy').remove();
                    jQuery.each(data.data.detail,function(k,v){
                     var copy = jQuery('.tr-copy').clone(true);
                    copy.removeClass('tr-copy');
                    copy.attr('data-id',v.product);
                    copy.find('.name').text(v.code+' - '+v.name);
                    copy.find('.unit').text(v.unit_name);
                    copy.find('.price').text(formatNumber(v.price));
                    copy.find('.touchspin').val(0); 
                    copy.find('.amount').text(formatNumber(v.price*0));                     
                    jQuery('#table-return').find('tbody').append(copy);
                    initTouchspin(copy.find('.touchspin'),v.quantity,v);
                     });
                     Total();
                }else{
                    jQuery('#table-return tbody').find('tr').not('.tr-copy').remove();  
                    jQuery('.touchspin').val(0);
                    Total();
                    bootbox.alert({title: 'Thông báo',message: 'Không tìm thấy hóa đơn này !',className: "alert"});    
                }      
            },true);  
        })
    };

    var initTouchspin = function(elem,quantity,data){
        var touchspin = elem;
          touchspin.TouchSpin({
            postfix: quantity,
            min: 0,
            max: quantity,
            postfix_extraclass: "btn green",  
            buttondown_class: "btn blue",
            buttonup_class: "btn red"
        });
        touchspin.on('change',function(){
            var $this = jQuery(this).parents('tr');
            var number = jQuery(this).val();
            $this.find('.price').text(formatNumber(data.price));
            $this.find('.amount').text(formatNumber(data.price * number));  
            Total();
        });        
    };

    return {
        //main function to initiate the module
        init: function () {
            link();
            initPickers();
            initSearchBill();
            initSaveReturnBill();
            initCancelBill();
        }
        
    };

}();

jQuery(document).ready(function() {    
   Main.init(); 
});
