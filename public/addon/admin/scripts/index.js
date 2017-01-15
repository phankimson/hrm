var Dashboard = function() {
    var url;
      var link  = function(){
          url = Dashboard.url;
          return url;
      };   
     var AppendData = function(elem,value,date){
          var result = jQuery(elem).find('.hidden').not('h2').clone(true);
            result.removeClass('hidden');
            result.find('.mt-action-img img').attr('src',App.getHostPath()+value.image);
            result.find('.mt-action-author').text(value.fullname);
            result.find('.mt-action-desc').text(value.position);
            result.find('.mt-action-date').text(formatDate(date));
            jQuery(elem).append(result); 
     } 
     var loadChart= function(data){
         jQuery.post( url['load_chart_url'],data, function( result ) {
            EPosUiBlock.show_loading();
            if(result){
                jQuery('.mt-action').not('.hidden').remove();
           if(result.e.length>0){
             jQuery('.birthday-base').find('h2').addClass('hidden');   
               jQuery.each(result.e,function(k,v){  
              AppendData('.birthday-base',v,v.birthday); 
               });
           }else{
              jQuery('.birthday-base').find('h2').removeClass('hidden');   
           }
           if(result.c.length>0){
               jQuery('.contract-base').find('h2').addClass('hidden');   
               jQuery.each(result.c,function(k,v){  
              AppendData('.contract-base',v,v.contract_end);
                });
            }else{
                  jQuery('.contract-base').find('h2').removeClass('hidden');   
            }
            jQuery('.caption-helper.change').text(jQuery('#dashboard-report-range span').html())
            }else{
                bootbox.alert('Không có dữ liệu !');
            }
            EPosUiBlock.hide_loading();
          });
     };
    return {
        initDashboardDaterange: function() {
            if (!jQuery().daterangepicker) {
                return;
            }

            jQuery('#dashboard-report-range').daterangepicker({
                "ranges": {
                      'Today': [moment(), moment()],
                    'Yesterday': [moment().subtract(1,'days'), moment().subtract(1,'days')],
                    'Last 7 Days': [moment().subtract(6,'days'), moment()],
                    'Last 30 Days': [moment().subtract(29,'days'), moment()],
                    'This Month': [moment().startOf('month'), moment().endOf('month')],
                    'Last Month': [moment().subtract(1,'month').startOf('month'), moment().subtract(1,'month').endOf('month')]
                },
                "locale": {
                    "format": "DD/MM/YYYY",
                    "separator": " - ",
                    "applyLabel": "Apply",
                    "cancelLabel": "Cancel",
                    "fromLabel": "From",
                    "toLabel": "To",
                    "customRangeLabel": "Custom",
                    "daysOfWeek": [
                        "Su",
                        "Mo",
                        "Tu",
                        "We",
                        "Th",
                        "Fr",
                        "Sa"
                    ],
                    "monthNames": [
                        "January",
                        "February",
                        "March",
                        "April",
                        "May",
                        "June",
                        "July",
                        "August",
                        "September",
                        "October",
                        "November",
                        "December"
                    ],
                    "firstDay": 1
                },
                //"startDate": "11/08/2015",
                //"endDate": "11/14/2015",
                opens: (App.isRTL() ? 'right' : 'left'),
            }, function(start, end, label) {
                jQuery('#dashboard-report-range span').html(start.format('DD/MM/YYYY') + ' - ' + end.format('DD/MM/YYYY'));
            });
             jQuery('#dashboard-report-range').on('hide.daterangepicker', function(ev, picker) {
           var lst_data = {"startDate":picker.startDate.format('YYYY-MM-DD'),"endDate":picker.endDate.format('YYYY-MM-DD')};
            //do something, like clearing an input
//           alert(picker.startDate.format('DD-MM-YYYY')+'-'+picker.endDate.format('DD-MM-YYYY'));
           loadChart(lst_data);
          });
//            jQuery('#dashboard-report-range span').html(moment().subtract('days', 29).format('MMMM D, YYYY') + ' - ' + moment().format('MMMM D, YYYY'));
            jQuery('#dashboard-report-range').show();
        },
        
        init: function() {
            link();
            this.initDashboardDaterange();  
            jQuery('#notification').modal('show');
        }
    };

}();

if (App.isAngularJsApp() === false) {
    jQuery(document).ready(function() {
        Dashboard.init(); // init metronic core componets
    });
}