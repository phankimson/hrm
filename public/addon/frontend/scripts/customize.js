var Customize = function () {
    var initAddTabs = function(){
        jQuery('.add-tabs').on('click',function(){
            var nameTabs = jQuery(this).find('.text-menu').html();
            var href = jQuery(this).attr('data-href');
            var check_href = 0;
            //Kiểm tra đã có href chưa
                jQuery('#tab-menu').find('li').each(function(k,v){
                    var a = jQuery(v).children('a').attr('data-target');
                 if(a == '#'+href){
                     check_href = 1;
                      return false;
                  } 
               });
            if(check_href==0){
  	// Tạo li tab
            var elem = jQuery('#tab-menu li:first').clone(true);
                elem.find('a').html(nameTabs);
                elem.find('a').attr('data-target','#'+href);
                elem.removeClass('hidden');
                elem.appendTo('#tab-menu');
  	// Tạo tab content
           jQuery('#tab-pane-menu .tab-pane').removeClass('active');
            var pane = jQuery('#tab-pane-menu div:first').clone(true);
                pane.attr('id',href);
                pane.removeClass('hidden').addClass('active');
                pane.appendTo('.tab-content');  
            }    
         jQuery.get(href, function(data) {
                jQuery('#'+href).html(data);
            });
            
  	//Kích hoạt tab
  	jQuery('#tab-menu a[data-target="#'+href+'"]').tab('show');
        });
    };
    //Load Ajax cho Tabs
    var initAjaxTabs = function(){
            jQuery('[data-toggle="tabajax"]').click(function(e) {
            var $this = jQuery(this),
                loadurl = $this.attr('href'),
                targ = $this.attr('data-target');

            jQuery.get(loadurl, function(data) {
                jQuery(targ).html(data);
            });

            $this.tab('show');
            return false;
        });
    };
    // Đóng Tabs
    var initCloseTabs = function(){
        jQuery('.close-tabs').on('click',function(){
            jQuery(this).attr('href','#');
            var target = jQuery(this).parent('li').find('a').attr('data-target');
            jQuery(this).parent().remove();
            jQuery(target).remove();
            // make the new tab active
            var loadurl = jQuery('#tab-menu li:last').children('a').attr('href');
              jQuery.get(loadurl, function(data) {
                jQuery('#'+loadurl).html(data);
            });
            jQuery('#tab-pane-menu #'+loadurl).addClass('active');
            jQuery('#tab-menu a[data-target="#'+loadurl+'"]').tab('show');
        });
    };

    return {
        //main function to initiate the module
        init: function () {
            initAjaxTabs();
            initCloseTabs();
            initAddTabs();
        }
    };

}();

jQuery(document).ready(function() {    
   Customize.init(); 
});
