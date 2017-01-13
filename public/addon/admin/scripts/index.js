var Dashboard = function() {
    var url;var plot1;var plot2;var plot3;
      var link  = function(){
          url = Dashboard.url;
          return url;
      };   
    function labelFormatter(label, series) {
		return "<div style='font-size:8pt; text-align:center; padding:2px; color:white;'>" + label + "<br/>" + Math.round(series.percent) +  "%<br/>(" + series.data[0][1] +")</div>";
	}
     function showChartTooltip(x, y, xValue, yValue) {
                jQuery('<div id="tooltip" class="chart-tooltip">' + yValue + '<\/div>').css({
                    position: 'absolute',
                    display: 'none',
                    top: y - 40,
                    left: x - 40,
                    border: '0px solid #ccc',
                    padding: '2px 6px',
                    'background-color': '#fff'
                }).appendTo("body").fadeIn(200);
            }   
            
            
     var loadChart= function(data){
         jQuery.post( url['load_chart_url'],data, function( result ) {
            EPosUiBlock.show_loading();
            if(result){
            plot1.setData(result.quantity_chart);
            plot1.setupGrid(); //only necessary if your new data will change the axes or grid
            plot1.draw();
            plot2.setData(result.revenue_chart);
            plot2.setupGrid(); //only necessary if your new data will change the axes or grid
            plot2.draw();
            plot3.setData(result.amount_chart_cost);
            plot3.setupGrid(); //only necessary if your new data will change the axes or grid
            plot3.draw();
            jQuery('.caption-helper.change').text(jQuery('#dashboard-report-range span').html())
            }else{
                bootbox.alert('Không có dữ liệu !');
            }
            EPosUiBlock.hide_loading();
          });
     };
    return {
        initPlotPieChart1: function(){
          var data = Dashboard.data;
          if (jQuery('#site_statistics_1').size() != 0) {

                jQuery('#site_statistics_loading_1').hide();
                jQuery('#site_statistics_content_1').show();
          plot1 =  jQuery.plot('#site_statistics_1', data, {
                series: {
                    pie: {
                        show: true,
                        radius: 1,
                        label: {
                            show: true,
                            radius: 2/3,
                            formatter: labelFormatter,
                            threshold: 0.1
                        }
                    }
                },
                legend: {
                    show: false
                }
            });
         }
       

        },
         initPlotPieChart2: function(){
            var data = Dashboard.data1;
          if (jQuery('#site_statistics_2').size() != 0) {

                jQuery('#site_statistics_loading_2').hide();
                jQuery('#site_statistics_content_2').show();
          plot2 = jQuery.plot('#site_statistics_2', data, {
                series: {
                    pie: {
                        show: true,
                        radius: 1,
                        label: {
                            show: true,
                            radius: 2/3,
                            formatter: labelFormatter,
                            threshold: 0.1
                        }
                    }
                },
                legend: {
                    show: false
                }
            });
         }      
        },
        
        initPlotPieChart3: function(){
            var data = Dashboard.data4;
          if (jQuery('#site_statistics_3').size() != 0) {

                jQuery('#site_statistics_loading_3').hide();
                jQuery('#site_statistics_content_3').show();
           plot3 = jQuery.plot('#site_statistics_3', data, {
                series: {
                    pie: {
                        show: true,
                        radius: 1,
                        label: {
                            show: true,
                            radius: 2/3,
                            formatter: labelFormatter,
                            threshold: 0.1
                        }
                    }
                },
                legend: {
                    show: false
                }
            });
         }      
        },
        
        
        initPlotPointChart1:function(){
             
          if (jQuery('#site_activities_1').size() != 0) {
                //site activities
                var previousPoint2 = null;
                jQuery('#site_activities_loading_1').hide();
                jQuery('#site_activities_content_1').show();
                var data = Dashboard.data2; 
                var arr = [];
                jQuery.each(data,function(k,v){
                     var hue_dark = 'rgb(' + (Math.floor((256-199)*Math.random()) + 202) + ',' + (Math.floor((256-199)*Math.random()) + 202) + ',' + (Math.floor((256-199)*Math.random()) + 202) + ')';  
                     var hue = 'rgb(' + (Math.floor((256-199)*Math.random()) + 200) + ',' + (Math.floor((256-199)*Math.random()) + 200) + ',' + (Math.floor((256-199)*Math.random()) + 200) + ')'; 
                     var line = {'data': v,'lines': {'fill': 0.2,'lineWidth': 0,},'color': [hue_dark]};
                     var point = {'data': v,'points': {'show': true,'fill': true,'radius': 4,'fillColor': hue,'lineWidth': 2},'color': hue,'shadowSize': 1}
                     var line1 =  {'data': v,'lines': {'show': true,'fill': false,'lineWidth': 3},'color': hue, 'shadowSize': 0}
                     arr.push(line);
                     arr.push(point);
                     arr.push(line1);
                     jQuery('#note-chart').append("<div class='col-md-3 col-sm-3 col-xs-6 text-stat'><span class='label label-sm' style='background:"+hue+";color:black'>"+k+"</span><h3></h3></div>")
                 });
                var plot_statistics = jQuery.plot(jQuery("#site_activities_1"),arr,                                      
                    {
                        xaxis: {
                            tickLength: 0,
                            tickDecimals: 0,
                            mode: "categories",
                            min: 0,
                            font: {
                                lineHeight: 18,
                                style: "normal",
                                variant: "small-caps",
                                color: "#6F7B8A"
                            }
                        },
                        yaxis: {
                            ticks: 5,
                            tickDecimals: 0,
                            tickColor: "#eee",
                            font: {
                                lineHeight: 14,
                                style: "normal",
                                variant: "small-caps",
                                color: "#6F7B8A"
                            }
                        },
                        grid: {
                            hoverable: true,
                            clickable: true,
                            tickColor: "#eee",
                            borderColor: "#eee",
                            borderWidth: 1
                        }
                    });

                jQuery("#site_activities_1").bind("plothover", function(event, pos, item) {
                    jQuery("#x").text(pos.x.toFixed(2));
                    jQuery("#y").text(pos.y.toFixed(2));
                    if (item) {
                        if (previousPoint2 != item.dataIndex) {
                            previousPoint2 = item.dataIndex;
                            jQuery("#tooltip").remove();
                            var x = item.datapoint[0].toFixed(2),
                                y = item.datapoint[1].toFixed(2);
                            showChartTooltip(item.pageX, item.pageY, item.datapoint[0], item.datapoint[1] + ' Cái');
                        }
                    }
                });

                jQuery('#site_activities_1').bind("mouseleave", function() {
                    jQuery("#tooltip").remove();
                });
            }   
        },
        initPlotPointChart2:function(){
             
          if (jQuery('#site_activities_2').size() != 0) {
                //site activities
                var previousPoint2 = null;
                jQuery('#site_activities_loading_2').hide();
                jQuery('#site_activities_content_2').show();
                var data = Dashboard.data3; 
                var arr = [];
                jQuery.each(data,function(k,v){
                     var hue_dark = 'rgb(' + (Math.floor((256-199)*Math.random()) + 202) + ',' + (Math.floor((256-199)*Math.random()) + 202) + ',' + (Math.floor((256-199)*Math.random()) + 202) + ')';  
                     var hue = 'rgb(' + (Math.floor((256-199)*Math.random()) + 200) + ',' + (Math.floor((256-199)*Math.random()) + 200) + ',' + (Math.floor((256-199)*Math.random()) + 200) + ')'; 
                     var line = {'data': v,'lines': {'fill': 0.2,'lineWidth': 0,},'color': [hue_dark]};
                     var point = {'data': v,'points': {'show': true,'fill': true,'radius': 4,'fillColor': hue,'lineWidth': 2},'color': hue,'shadowSize': 1}
                     var line1 =  {'data': v,'lines': {'show': true,'fill': false,'lineWidth': 3},'color': hue, 'shadowSize': 0}
                     arr.push(line);
                     arr.push(point);
                     arr.push(line1);
                     jQuery('#note-chart-2').append("<div class='col-md-3 col-sm-3 col-xs-6 text-stat'><span class='label label-sm' style='background:"+hue+";color:black'>"+k+"</span><h3></h3></div>")
                 });
                var plot_statistics = jQuery.plot(jQuery("#site_activities_2"),arr,                                      
                    {
                        xaxis: {
                            tickLength: 0,
                            tickDecimals: 0,
                            mode: "categories",
                            min: 0,
                            font: {
                                lineHeight: 18,
                                style: "normal",
                                variant: "small-caps",
                                color: "#6F7B8A"
                            }
                        },
                        yaxis: {
                            ticks: 5,
                            tickDecimals: 0,
                            tickColor: "#eee",
                            font: {
                                lineHeight: 14,
                                style: "normal",
                                variant: "small-caps",
                                color: "#6F7B8A"
                            }
                        },
                        grid: {
                            hoverable: true,
                            clickable: true,
                            tickColor: "#eee",
                            borderColor: "#eee",
                            borderWidth: 1
                        }
                    });

                jQuery("#site_activities_2").bind("plothover", function(event, pos, item) {
                    jQuery("#x").text(pos.x.toFixed(2));
                    jQuery("#y").text(pos.y.toFixed(2));
                    if (item) {
                        if (previousPoint2 != item.dataIndex) {
                            previousPoint2 = item.dataIndex;
                            jQuery("#tooltip").remove();
                            var x = item.datapoint[0].toFixed(2),
                                y = item.datapoint[1].toFixed(2);
                            showChartTooltip(item.pageX, item.pageY, item.datapoint[0], item.datapoint[1] + ' VNĐ');
                        }
                    }
                });

                jQuery('#site_activities_2').bind("mouseleave", function() {
                    jQuery("#tooltip").remove();
                });
            }   
        },
        
         initPlotBarChart1:function(){
            if (jQuery('#site_activities_3').size() != 1) {                
                    return;
                }
                jQuery('#site_activities_loading_3').hide();
                jQuery('#site_activities_content_3').show();
                var data = Dashboard.data5;
                var stack = 0,
                    bars = true,
                    lines = false,
                    steps = false;
                var arr =  [];
                jQuery.each(data,function(k,v){
                    var label = { "label":k,"data": v ,"lines": {"lineWidth": 1},"shadowSize": 0};
                        arr.push(label);
                });
                function plotWithOptions() {
                    jQuery.plot($("#site_activities_3"),

                        arr

                        , {
                            series: {
                                stack: stack,
                                lines: {
                                    show: lines,
                                    fill: true,
                                    steps: steps,
                                    lineWidth: 0, // in pixels
                                },
                                bars: {
                                    show: bars,
                                    barWidth: 0.5,
                                    lineWidth: 0, // in pixels
                                    shadowSize: 0,
                                    align: 'center'
                                }
                            },
                            grid: {
                                tickColor: "#eee",
                                borderColor: "#eee",
                                borderWidth: 1
                            }
                        }
                    );
                }

//                $(".stackControls input").click(function(e) {
//                    e.preventDefault();
//                    stack = $(this).val() == "With stacking" ? true : null;
//                    plotWithOptions();
//                });
//
//                $(".graphControls input").click(function(e) {
//                    e.preventDefault();
//                    bars = $(this).val().indexOf("Bars") != -1;
//                    lines = $(this).val().indexOf("Lines") != -1;
//                    steps = $(this).val().indexOf("steps") != -1;
//                    plotWithOptions();
//                });

                plotWithOptions();  
           
        },
        
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
            this.initPlotPieChart1();
            this.initPlotPieChart2();
            this.initPlotPieChart3();
            this.initPlotPointChart1();
            this.initPlotPointChart2();
            this.initPlotBarChart1();           
        }
    };

}();

if (App.isAngularJsApp() === false) {
    jQuery(document).ready(function() {
        Dashboard.init(); // init metronic core componets
    });
}