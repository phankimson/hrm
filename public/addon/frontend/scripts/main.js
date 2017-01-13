var Main = function () {
    var data;var url;
    var loadData = function(){
          data = Main.data;
          return data;
    };  
     var link  = function(){
          url = Main.url;
          return url;
      };  
    var  $container  = jQuery('#container-mixitup');
    var initAddItem = function(){
        jQuery('.mt-card-item').on('click',function(){
            var arr = [];
            var tabs_active = jQuery('#tabs li.active').not('#tabs_dropdown').find('.tabs-item').attr('href');
            if(sessionStorage[tabs_active]){
                 bootbox.alert({title: 'Thông báo',message: "Bạn đã in bill. Vui lòng thanh toán !",className: "alert"});    
            }else{
               var id = jQuery(this).attr('data-id');
             arr = jQuery.grep(data, function( n, i ) {
                return ( n.id == id );
              })[0];
            var check_availability = jQuery(tabs_active).find('tbody tr[data-id="'+id+'"]');
            if(check_availability.length>0){
               var quantity =  check_availability.find('.touchspin').val();
               check_availability.find('.touchspin').val(parseInt(quantity)+1);
               check_availability.find('.amount').text(formatNumber(arr.price*(parseInt(quantity)+1))); 
            }else{
                if(tabs_active){
            var copy = jQuery('.tr-copy').clone(true);
                copy.removeClass('tr-copy');
                copy.attr('data-id',arr.id);
                copy.find('.name').text(arr.text);
                copy.find('.unit').text(arr.unit_name);
                copy.find('.price').text(formatNumber(arr.price));
                copy.find('.touchspin').val(1); 
                copy.find('.amount').text(formatNumber(arr.price*1)); 
                jQuery(tabs_active).find('tbody').append(copy);
                initTouchspin(copy.find('.touchspin'));
               }else{
                   bootbox.alert({title: 'Thông báo',message: "Bạn chưa thêm hóa đơn !",className: "alert"});    
               }
            }
              Total();   
            }
          
        }); 
    };
    
    var initMixitup = function(){
           $container.mixItUp({
           selectors: {
             filter: '.filter'
//             sort: '.sort-1'
           }
         });
    };
    
    var initPrint = function(){
        jQuery('.print').on('click',function(){           
            jQuery('#printbill').find('tbody').empty();
            var ret ='';
            var data ={};var product =[];
            var tabs_active = jQuery('#tabs li.active').not('#tabs_dropdown').find('.tabs-item').attr('href');
              if(jQuery(tabs_active).find('tbody tr').length >0){
            data["invoice"] =  jQuery(tabs_active).find('.invoice').val();
            data["customer"] = jQuery(tabs_active).find('#customer').val();
              jQuery(tabs_active+ ' tbody tr').each(function(i,v){
                  var p = {'id' : jQuery(this).attr('data-id'),'quantity':jQuery(this).find('.touchspin').val()};
                  product.push(p);
              });
             data["product"] =  product;
               var postdata = {data : JSON.stringify(data)};  
            RequestURLWaiting(url['save_url'],'json',postdata,function(data){
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
                    jQuery.each(data.data.detail,function(k,v){
                      ret += '<tr style="text-align: center;font-size:12px"><td>'+v.name+'</td><td>'+formatNumber(v.price)+'</td><td>'+v.quantity+'</td><td>'+formatNumber(parseInt(v.quantity*v.price))+'</td></tr>';   
                    });
                     ret +='<tr style="color:red;font-weight: bold;text-align: center;font-size:12px"><td>Tổng cộng</td><td></td><td>'+data.data.quantity+'</td><td>'+formatNumber(data.data.amount)+'</td></tr>';
                    jQuery('#printbill').find('span').text('');          
                    jQuery('#printbill').find('tbody').append(ret);  
                    jQuery('#printbill').removeClass('hidden');
                    jQuery('#printbill').print();   
                    jQuery('#printbill').addClass('hidden');
                    jQuery('#printbill').find('tbody').empty();
                    sessionStorage[tabs_active] = data.data.id;   
                }else{
                    bootbox.alert({title: 'Thông báo',message: data.message,className: "alert"});    
                }      
            },true);  
             }else{
            bootbox.alert({title: 'Thông báo',message: "Bạn chưa có sản phẩm nào !",className: "alert"});    
        }
//            jQuery(tabs_active).find('tbody tr').each(function(i,v){
//                var arr = [];               
//                var id = jQuery(this).attr('data-id');
//                var number = jQuery(this).find('.touchspin').val();
//                arr = jQuery.grep(data, function( n, i ) {
//                return ( n.id == id );
//              })[0];
//               ret += '<tr style="text-align: center;font-size:12px"><td>'+arr.name+'</td><td>'+formatNumber(arr.price)+'</td><td>'+number+'</td><td>'+formatNumber(parseInt(number*arr.price))+'</td></tr>';
//               total_number += parseInt(number);
//               total_amount += parseInt(number*arr.price);
//            });
//             ret +='<tr style="color:red;font-weight: bold;text-align: center;font-size:12px"><td>Tổng cộng</td><td></td><td>'+total_number+'</td><td>'+formatNumber(total_amount)+'</td></tr>';
//            jQuery('#printbill').find('span').text('');          
//            jQuery('#printbill').find('tbody').append(ret);  
//            jQuery('#printbill').removeClass('hidden');
//            jQuery('#printbill').print();   
//            jQuery('#printbill').addClass('hidden');
        });
    };
    
    var initkeyUpPayment = function(){
        jQuery('input[name="amount"]').number( true,0 ,',', '.' );
        jQuery('input[name="paid"]').number( true,0 ,',', '.' );
        jQuery('input[name="paid"]').keyup(function(){
            var amount = jQuery('input[name="amount"]').val();
            var paid = jQuery(this).val();
            jQuery('input[name="return"]').val(formatNumber(paid-amount));
        });
    };
    
    var initOpenPayment = function(){
       jQuery('.payment').on('click',function(){   
         var tabs_active = jQuery('#tabs li.active').not('#tabs_dropdown').find('.tabs-item').attr('href');
        if(jQuery(tabs_active).find('tbody tr').length >0){
        jQuery('#payment-content').modal('show');
        jQuery('input[name="amount"]').val(jQuery(tabs_active).find('.total-amount').text().replace(".", ""));
        jQuery('input[name="paid"]').val('');
        jQuery('input[name="return"]').val('');
        }else{
             bootbox.alert({title: 'Thông báo',message: "Bạn chưa có sản phẩm nào !",className: "alert"});    
        }
       });    
    };
    
     var initClosePayment = function(){
       jQuery('.cancel-payment').on('click',function(){   
        jQuery('#payment-content').modal('hide');
       });    
    };
    var initCloseDropdown = function(){
        if(jQuery('#tabs_dropdown_add').find('li').length ==0){
            jQuery('#tabs_dropdown').addClass('hidden');
        }
    };
    
    var initPayment = function(){
       jQuery('.save-payment').on('click',function(){
        var data = {};    
       var tabs_active = jQuery('#tabs li.active').not('#tabs_dropdown').find('.tabs-item').attr('href'); 
       if(sessionStorage[tabs_active]){ 
       data["id"] = sessionStorage[tabs_active];   
       data["return_payment"] = jQuery('input[name="return"]').val();
       if(data["return_payment"]>=0){
       data['type'] = jQuery('#payment option:selected').val();    
       data['amount'] = jQuery('input[name="amount"]').val();
       data['paid'] = jQuery('input[name="amount"]').val();     
       var postdata = {data :JSON.stringify(data)};
            RequestURLWaiting(url['payment_url'],'json',postdata,function(data){
           if(data.status == true){  
                 sessionStorage.removeItem(tabs_active);
                 jQuery('#tabs li.active').not('#tabs_dropdown').remove();
                 jQuery(tabs_active).remove();
                 jQuery('#payment-content').modal('hide');
                 initCloseDropdown();
                 bootbox.alert({title: 'Thông báo',message: data.message,className: "alert"});    
                }else{
                 bootbox.alert({title: 'Thông báo',message: data.message,className: "alert"});    
                }      
            },true);  
             jQuery('#tabs a:last').tab('show');   
         }else{
            bootbox.alert({title: 'Thông báo',message: 'Bạn chưa thanh toán đủ tiền .',className: "alert"});   
         }
          }else{
            bootbox.alert({title: 'Thông báo',message: "Bạn chưa in bill !",className: "alert"});   
        }
       });        
    };
    var initTouchspin = function(elem){
        var touchspin = elem;
          touchspin.TouchSpin({
            buttondown_class: "btn blue",
            buttonup_class: "btn red"
        });
        touchspin.on('change',function(){
            var arr = [];
            var $this = jQuery(this).parents('tr');
            var id = $this.attr('data-id');
            var number = jQuery(this).val();
            arr = jQuery.grep(data, function( n, i ) {
                return ( n.id == id );
              })[0];
            $this.find('.price').text(formatNumber(arr.price));
            $this.find('.amount').text(formatNumber(arr.price * number));  
            Total();
        });        
    };
    var Total = function(){
        var total_quantity = 0;
        var total_amount = 0;
        jQuery('.tab-pane.active').find('.touchspin').each(function(){
           total_quantity += parseInt(jQuery(this).val());
        });
        jQuery('.tab-pane.active').find('.amount').each(function(){
           total_amount += parseInt(jQuery(this).text().replace(".",""));
        });
        jQuery('.tab-pane.active').find('.total-quantity').text(total_quantity);
        jQuery('.tab-pane.active').find('.total-amount').text(formatNumber(total_amount));
    };
    var initSearch = function(){
      jQuery('#search-product').on('change',function(){
       var val = $(this).val();
       var state = $container.mixItUp('getState');
         var $filtered = state.$targets.filter(function(index, element){
            return jQuery(this).text().toString().indexOf( val.trim() ) >= 0;
          });
            
          $container.mixItUp('filter', $filtered);
      });  
    };
    var initChangeGroup = function(){
        jQuery('.filter').on('click',function(){
           var text = jQuery(this).text();
           jQuery('#title').text(text);
        });
    };  
    
    var initRemoveItem = function(){
        jQuery('.remove-item').on('click',function(){
            jQuery(this).parents('tr').remove();
             Total();
        });  
    };
    
    var initRemoveTabs = function(){
        jQuery('.remove-tabs').on('click',function(){
            var tabs_active = jQuery('#tabs li.active').not('#tabs_dropdown').find('.tabs-item').attr('href'); 
             if(sessionStorage[tabs_active]){ 
               bootbox.alert({title: 'Thông báo',message: "Bạn đã in bill. Vui lòng thanh toán !",className: "alert"});    
             }else{
                jQuery(this).parents('.tab-pane').remove();
                jQuery('#tabs li.active').not('#tabs_dropdown').remove();
                initCloseDropdown();
                jQuery('#tabs a:last').tab('show');    
             }            
        });  
    };
    
    var initAddTabs = function(){
        jQuery('#btnAdd').click(function (e) {
            var nextTab = jQuery('.tabs-item').size()+1;
            var tab_li = jQuery('<li><a href="#tab_'+nextTab+'" class="tabs-item" data-toggle="tab">HĐ '+nextTab+'</a></li>');
               // create the tab
            if(nextTab>5){
            tab_li.appendTo('#tabs_dropdown_add');    
                if(jQuery('#tabs_dropdown').hasClass('hidden')){
                   jQuery('#tabs_dropdown').removeClass('hidden'); 
                }
            }else{         
            tab_li.appendTo('#tabs');    
            }
            var copy = jQuery('#tab-copy').clone(true);
            copy.attr('id','tab_'+nextTab+'');
            copy.find('.tr-copy').remove();
           jQuery.post( url['load_url'], function( data ) {
            copy.find('.invoice').val(data.voucher);
          });
            // create the tab content
            copy.appendTo('.tab-content');
           // make the new tab active
            if(nextTab>5){
            jQuery('#tabs_dropdown_add a:last').tab('show');   
            }else{
            jQuery('#tabs a:last').tab('show');   
            }
    });

    };
    return {
        //main function to initiate the module
        init: function () {
            loadData();
            link();
            initMixitup();
            initSearch();
            initChangeGroup(); 
            initAddItem();
            initRemoveItem();            
            initAddTabs();
            initRemoveTabs();
            initPrint();
            initPayment();
            initOpenPayment();
            initClosePayment();
            initkeyUpPayment();          
        }
        
    };

}();

jQuery(document).ready(function() {    
   Main.init(); 
    //Backdrop z-index fix
      $(document).on('shown.bs.modal', '.modal', function (event) {
            var zIndex = 10010 + (10 * $('.modal,.in').length);
            $(this).css('z-index', zIndex);
            setTimeout(function() {
                $('.modal-backdrop').not('.modal-stack').css('z-index', zIndex - 1).addClass('modal-stack');
            }, 0);
        });
});
