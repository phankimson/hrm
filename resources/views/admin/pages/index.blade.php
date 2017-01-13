<!DOCTYPE html>
@extends('admin.layouts.default')   
@section('title')        
<title>EPOS HRM | {{trans('index.title')}}</title>
@stop
@section('extra_css')
        <!-- BEGIN PAGE LEVEL PLUGINS -->
        <link href="{{url('public/global/plugins/bootstrap-daterangepicker/daterangepicker.min.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{url('public/global/plugins/morris/morris.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{url('public/global/plugins/fullcalendar/fullcalendar.min.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{url('public/global/plugins/jqvmap/jqvmap/jqvmap.css')}}" rel="stylesheet" type="text/css" />
        <!-- END PAGE LEVEL PLUGINS -->        
@stop    
@section('content')
{{'',  $option_dt = $options->where('code','MAX_DAY_DATATABLE')->first(),
        $end = date("Y-m-d"),
        $start = date("Y-m-d",strtotime($option_dt->value,strtotime($end)))}}
            <!-- BEGIN CONTENT -->
            <div class="page-content-wrapper">
                <!-- BEGIN CONTENT BODY -->
                <div class="page-content">                  
                    <div class="page-bar">
                        <ul class="page-breadcrumb">
                            <li>
                                <a href="{{url('/')}}">{{trans('menu.index')}}</a>
                                <i class="fa fa-circle"></i>
                            </li>
                            <li>
                                <span>{{trans('menu.chart')}}</span>
                            </li>
                        </ul>
                        <div class="page-toolbar">
                            <div id="dashboard-report-range" class="pull-right tooltips btn btn-sm" data-container="body" data-placement="bottom" data-original-title="Change dashboard date range">
                                <i class="icon-calendar"></i>&nbsp;
                                <span class="thin uppercase hidden-xs"></span>&nbsp;
                                <i class="fa fa-angle-down"></i>
                            </div>
                        </div>
                    </div>
                    <!-- END PAGE BAR -->
                    <!-- BEGIN PAGE TITLE-->
                    <h3 class="page-title"> {{trans('menu.chart')}}
                        <small>{{trans('index.statistics')}}</small>
                    </h3>
                    <!-- END PAGE TITLE-->
                    <!-- END PAGE HEADER-->
                    <!-- BEGIN DASHBOARD STATS 1-->                    
                    <div class="clearfix"></div>
                    <div class="row">
                        <div class="col-md-6 col-sm-6">
                            <!-- BEGIN PORTLET-->
                            <div class="portlet light bordered">
                                <div class="portlet-title">
                                    <div class="caption">
                                        <i class="icon-pie-chart font-green"></i>
                                        <span class="caption-subject font-green bold uppercase">{{trans('index.chart_revenue_cost_profit')}}</span>
                                        <span class="caption-helper change">{{date("d/m/Y",strtotime($start)).'-'.date("d/m/Y",strtotime($end))}}</span>
                                    </div>                                    
                                </div>
                                <div class="portlet-body">
                                    <div id="site_statistics_loading_3">
                                        <img src="{{url('public/global/img/loading.gif')}}" alt="loading" /> </div>
                                    <div id="site_statistics_content_3" class="display-none">
                                        <div id="site_statistics_3" class="chart"> </div>
                                    </div>
                                </div>
                            </div>
                            <!-- END PORTLET-->
                        </div>  
                        <div class="col-md-6 col-sm-6">
                            <!-- BEGIN PORTLET-->
                            <div class="portlet light bordered">
                                <div class="portlet-title">
                                    <div class="caption">
                                        <i class="icon-bar-chart font-green"></i>
                                        <span class="caption-subject font-green bold uppercase">{{trans('index.chart_revenue_cost_profit')}}</span>
                                        <span class="caption-helper">{{date('Y')}}</span>
                                    </div>                                    
                                </div>
                                <div class="portlet-body">
                                    <div id="site_activities_loading_3">
                                        <img src="{{url('public/global/img/loading.gif')}}" alt="loading" /> </div>
                                    <div id="site_activities_content_3" class="display-none">
                                        <div id="site_activities_3" class="chart"> </div>
                                    </div>
                                     <div style="margin: 20px 0 10px 30px">
                                        <div class="row" id="note-chart-3">                                            
                                        </div>
                                     </div>    
                                </div>
                            </div>
                            <!-- END PORTLET-->
                        </div>  
                    </div>
                    <!-- END DASHBOARD STATS 1-->
                    <div class="row">
                        <div class="col-md-6 col-sm-6">
                            <!-- BEGIN PORTLET-->
                            <div class="portlet light bordered">
                                <div class="portlet-title">
                                    <div class="caption">
                                        <i class="icon-pie-chart font-green"></i>
                                        <span class="caption-subject font-green bold uppercase">{{trans('index.chart_quantity')}}</span>
                                        <span class="caption-helper change">{{date("d/m/Y",strtotime($start)).'-'.date("d/m/Y",strtotime($end))}}</span>
                                    </div>                                    
                                </div>
                                <div class="portlet-body">
                                    <div id="site_statistics_loading_1">
                                        <img src="{{url('public/global/img/loading.gif')}}" alt="loading" /> </div>
                                    <div id="site_statistics_content_1" class="display-none">
                                        <div id="site_statistics_1" class="chart"> </div>
                                    </div>
                                </div>
                            </div>
                            <!-- END PORTLET-->
                        </div>  
                        <div class="col-md-6 col-sm-6">
                            <!-- BEGIN PORTLET-->
                            <div class="portlet light bordered">
                                <div class="portlet-title">
                                    <div class="caption">
                                        <i class="icon-bar-chart font-green"></i>
                                        <span class="caption-subject font-green bold uppercase">{{trans('index.chart_quantity')}}</span>
                                        <span class="caption-helper">{{date('Y')}}</span>
                                    </div>                                    
                                </div>
                                <div class="portlet-body">
                                    <div id="site_activities_loading_1">
                                        <img src="{{url('public/global/img/loading.gif')}}" alt="loading" /> </div>
                                    <div id="site_activities_content_1" class="display-none">
                                        <div id="site_activities_1" class="chart"> </div>
                                    </div>
                                     <div style="margin: 20px 0 10px 30px">
                                        <div class="row" id="note-chart">                                            
                                        </div>
                                     </div>    
                                </div>
                            </div>
                            <!-- END PORTLET-->
                        </div>  
                    </div>
                    <div class="row">
                        <div class="col-md-6 col-sm-6">
                            <!-- BEGIN PORTLET-->
                            <div class="portlet light bordered">
                                <div class="portlet-title">
                                    <div class="caption">
                                        <i class="icon-pie-chart font-green"></i>
                                        <span class="caption-subject font-green bold uppercase">{{trans('index.chart_revenue')}}</span>
                                        <span class="caption-helper change">{{date("d/m/Y",strtotime($start)).'-'.date("d/m/Y",strtotime($end))}}</span>
                                    </div>                                    
                                </div>
                                <div class="portlet-body">
                                    <div id="site_statistics_loading_2">
                                        <img src="{{url('public/global/img/loading.gif')}}" alt="loading" /> </div>
                                    <div id="site_statistics_content_2" class="display-none">
                                        <div id="site_statistics_2" class="chart"> </div>
                                    </div>
                                </div>
                            </div>
                            <!-- END PORTLET-->
                        </div>                         
                        <div class="col-md-6 col-sm-6">
                            <!-- BEGIN PORTLET-->
                            <div class="portlet light bordered">
                                <div class="portlet-title">
                                    <div class="caption">
                                        <i class="icon-bar-chart font-green"></i>
                                        <span class="caption-subject font-green bold uppercase">{{trans('index.chart_revenue')}}</span>
                                        <span class="caption-helper">{{date('Y')}}</span>
                                    </div>                                    
                                </div>
                                <div class="portlet-body">
                                    <div id="site_activities_loading_2">
                                        <img src="{{url('public/global/img/loading.gif')}}" alt="loading" /> </div>
                                    <div id="site_activities_content_2" class="display-none">
                                        <div id="site_activities_2" class="chart"> </div>
                                    </div>
                                     <div style="margin: 20px 0 10px 30px">
                                        <div class="row" id="note-chart-2">                                            
                                        </div>
                                     </div>    
                                </div>
                            </div>
                            <!-- END PORTLET-->
                        </div>  
                    </div>
                    
                    
                    
                    
                </div>
                <!-- END CONTENT BODY -->
            </div>
            <!-- END CONTENT -->
            <!-- BEGIN QUICK SIDEBAR -->
            <a href="javascript:;" class="page-quick-sidebar-toggler">
                <i class="icon-login"></i>
            </a>
            
            <!-- END QUICK SIDEBAR -->
        </div>
        <!-- END CONTAINER -->
        
        @stop           
        @section('extra_javascript')   
          <script>
            jQuery(document).ready(function() {
               Dashboard.url = <?= json_encode(['load_chart_url'=>'get/load-chart']);?>;               
           });
        </script>
          <!-- BEGIN PAGE LEVEL SCRIPTS -->

        <!-- END PAGE LEVEL SCRIPTS -->
         <!-- BEGIN PAGE LEVEL PLUGINS -->
        <script src="{{url('public/global/plugins/moment.min.js')}}" type="text/javascript"></script>
        <script src="{{url('public/global/plugins/bootstrap-daterangepicker/daterangepicker.min.js')}}" type="text/javascript"></script>
        <script src="{{url('public/global/plugins/flot/jquery.flot.js')}}" type="text/javascript"></script>
        <script src="{{url('public/global/plugins/flot/jquery.flot.pie.js')}}" type="text/javascript"></script>
        <script src="{{url('public/global/plugins/flot/jquery.flot.categories.min.js')}}" type="text/javascript"></script>
        <script src="{{url('public/global/plugins/flot/jquery.flot.resize.min.js')}}" type="text/javascript"></script>
        <!-- END PAGE LEVEL PLUGINS -->
          @stop      