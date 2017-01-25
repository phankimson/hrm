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
                <!-- INFO MODAL -->
                <div class="modal fade" id="notification" data-backdrop="true" role="dialog">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                    <h4 class="modal-title">Thông báo cập nhật</h4>
                                </div>
                                <div class="modal-body">                                     
                                    <div class="row">
                                        <div class="container">
                                        <h2 class="text-warning">Update</h2>
                                        <p>- Thông báo sinh nhật nhân viên</p> 
                                        <p>- Thông báo hợp đồng lao động sắp hết hạn</p> 
                                        <p>- Bảng tạm ứng lương</p> 
                                        <p>- Hợp đồng lao động</p> 
                                        <p>- Bảng tăng ca nhân viên</p> 
                                         <h2 class="text-warning">Fix</h2>
                                        <p>- Danh mục Chấm công</p> 
                                        <p>- Bảng chấm công</p> 
                                         <h4 class="text-warning col-sm-6 text-justify">Have nice day !!</h4>
                                        </div>
                                       
                                    </div> 
                                </div>                                
                            </div>
                            <!-- /.modal-content -->
                        </div>
                        <!-- /.modal-dialog -->
                    </div>
                <!-- INFO MODAL -->
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
                                        <i class="icon-emoticon-smile font-green"></i>
                                        <span class="caption-subject font-green bold uppercase">{{trans('index.birthday_employee')}}</span>
                                        <span class="caption-helper change">{{date("d/m/Y",strtotime($end)).'-'.date("d/m/Y",strtotime($start))}}</span>
                                    </div>                                    
                                </div>
                                <div class="portlet-body">
                                    <div class="mt-actions birthday-base">
                                        <div class="mt-action hidden">
                                                    <div class="mt-action-img">
                                                        <img style="width:45px;height:45px" src=""> </div>
                                                    <div class="mt-action-body">
                                                        <div class="mt-action-row">
                                                            <div class="mt-action-info ">
                                                                <div class="mt-action-icon ">
                                                                    <i class="icon-present"></i>
                                                                </div>
                                                                <div class="mt-action-details ">
                                                                    <span class="mt-action-author"></span>
                                                                    <p class="mt-action-desc"></p>
                                                                </div>
                                                            </div>
                                                            <div class="mt-action-datetime ">
                                                                <span class="mt-action-date"></span>
                                                                <span class="mt-action-dot bg-green"></span>                             
                                                            </div>
                                                            <div class="mt-action-buttons ">
                                                                <div class="btn-group btn-group-circle">                                                           
                                                                    <button type="button" class="btn btn-outline green btn-sm ">{{trans('index.birthday')}}</button>                                                   
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                        @if($employee->count()>0)
                                           <h2 class="hidden">{{trans('index.not')}}</h2>
                                        @foreach($employee as $e)
                                                <div class="mt-action">
                                                    <div class="mt-action-img">
                                                        <img style="width:45px;height:45px" src="{{url($e->image)}}"> </div>
                                                    <div class="mt-action-body">
                                                        <div class="mt-action-row">
                                                            <div class="mt-action-info ">
                                                                <div class="mt-action-icon ">
                                                                    <i class="icon-present"></i>
                                                                </div>
                                                                <div class="mt-action-details ">
                                                                    <span class="mt-action-author">{{$e->fullname}}</span>
                                                                    <p class="mt-action-desc">{{$e->position}}</p>
                                                                </div>
                                                            </div>
                                                            <div class="mt-action-datetime ">
                                                                <span class="mt-action-date">{{date("d/m/Y",strtotime($e->birthday))}}</span>
                                                                <span class="mt-action-dot bg-green"></span>                             
                                                            </div>
                                                            <div class="mt-action-buttons ">
                                                                <div class="btn-group btn-group-circle">                                                           
                                                                    <button type="button" class="btn btn-outline green btn-sm {{date("d/m",strtotime($e->birthday)) === date("d/m")? 'active' :'' }}">{{trans('index.birthday')}}</button>                                                   
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                        @endforeach
                                        @else
                                        <h2>{{trans('index.not')}}</h2>
                                        @endif
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
                                        <i class="icon-paper-clip font-green"></i>
                                        <span class="caption-subject font-green bold uppercase">{{trans('index.labor_contract_comming')}}</span>
                                        <span class="caption-helper  change">{{date("d/m/Y",strtotime($end)).'-'.date("d/m/Y",strtotime($start))}}</span>
                                    </div>                                    
                                </div>
                                <div class="portlet-body">
                                    <div class="mt-actions contract-base">
                                        <div class="mt-action hidden">
                                                    <div class="mt-action-img">
                                                        <img style="width:45px;height:45px" src=""> </div>
                                                    <div class="mt-action-body">
                                                        <div class="mt-action-row">
                                                            <div class="mt-action-info ">
                                                                <div class="mt-action-icon ">
                                                                    <i class="icon-present"></i>
                                                                </div>
                                                                <div class="mt-action-details ">
                                                                    <span class="mt-action-author"></span>
                                                                    <p class="mt-action-desc"></p>
                                                                </div>
                                                            </div>
                                                            <div class="mt-action-datetime ">
                                                                <span class="mt-action-date"></span>
                                                                <span class="mt-action-dot bg-green"></span>                             
                                                            </div>
                                                            <div class="mt-action-buttons ">
                                                                <div class="btn-group btn-group-circle">                                                           
                                                                    <button type="button" class="btn btn-outline green btn-sm ">{{trans('index.birthday')}}</button>                                                   
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                        @if($contract->count()>0)
                                         <h2 class="hidden">{{trans('index.not')}}</h2>
                                        @foreach($contract as $e)
                                                <div class="mt-action">
                                                    <div class="mt-action-img">
                                                        <img style="width:45px;height:45px" src="{{url($e->image)}}"> </div>
                                                    <div class="mt-action-body">
                                                        <div class="mt-action-row">
                                                            <div class="mt-action-info">
                                                                <div class="mt-action-icon">
                                                                    <i class="icon-docs"></i>
                                                                </div>
                                                                <div class="mt-action-details ">
                                                                    <span class="mt-action-author">{{$e->fullname}}</span>
                                                                    <p class="mt-action-desc">{{$e->position}}</p>
                                                                </div>
                                                            </div>
                                                            <div class="mt-action-datetime ">
                                                                <span class="mt-action-date">{{date("d/m/Y",strtotime($e->contract_end))}}</span>
                                                                <span class="mt-action-dot bg-red"></span>                             
                                                            </div>
                                                            <div class="mt-action-buttons ">
                                                                <div class="btn-group btn-group-circle">                                                           
                                                                    <button type="button" class="btn btn-outline red btn-sm {{date("d/m",strtotime($e->contract_end)) === date("d/m")? 'active' :'' }}">{{trans('index.expire_contract')}}</button>                                                   
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                        @endforeach
                                        @else
                                        <h2>{{trans('index.not')}}</h2>
                                        @endif
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
                                        <i class="icon-badge font-green"></i>
                                        <span class="caption-subject font-green bold uppercase">{{trans('index.probationary_ending')}}</span>
                                        <span class="caption-helper change">{{date("d/m/Y",strtotime($end)).'-'.date("d/m/Y",strtotime($start))}}</span>
                                    </div>                                    
                                </div>
                                <div class="portlet-body">
                                    <div class="mt-actions birthday-base">
                                        <div class="mt-action hidden">
                                                    <div class="mt-action-img">
                                                        <img style="width:45px;height:45px" src=""> </div>
                                                    <div class="mt-action-body">
                                                        <div class="mt-action-row">
                                                            <div class="mt-action-info ">
                                                                <div class="mt-action-icon ">
                                                                    <i class="icon-like"></i>
                                                                </div>
                                                                <div class="mt-action-details ">
                                                                    <span class="mt-action-author"></span>
                                                                    <p class="mt-action-desc"></p>
                                                                </div>
                                                            </div>
                                                            <div class="mt-action-datetime ">
                                                                <span class="mt-action-date"></span>
                                                                <span class="mt-action-dot bg-blue"></span>                             
                                                            </div>
                                                            <div class="mt-action-buttons ">
                                                                <div class="btn-group btn-group-circle">                                                           
                                                                    <button type="button" class="btn btn-outline blue btn-sm ">{{trans('index.probationary')}}</button>                                                   
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                        @if($employee_probationary->count()>0)
                                           <h2 class="hidden">{{trans('index.not')}}</h2>
                                        @foreach($employee_probationary as $e)
                                                <div class="mt-action">
                                                    <div class="mt-action-img">
                                                        <img style="width:45px;height:45px" src="{{url($e->image)}}"> </div>
                                                    <div class="mt-action-body">
                                                        <div class="mt-action-row">
                                                            <div class="mt-action-info ">
                                                                <div class="mt-action-icon ">
                                                                    <i class="icon-like"></i>
                                                                </div>
                                                                <div class="mt-action-details ">
                                                                    <span class="mt-action-author">{{$e->fullname}}</span>
                                                                    <p class="mt-action-desc">{{$e->position}}</p>
                                                                </div>
                                                            </div>
                                                            <div class="mt-action-datetime ">
                                                                <span class="mt-action-date">{{date("d/m/Y",strtotime($e->end_probationary_coefficient))}}</span>
                                                                <span class="mt-action-dot bg-blue"></span>                             
                                                            </div>
                                                            <div class="mt-action-buttons ">
                                                                <div class="btn-group btn-group-circle">                                                           
                                                                    <button type="button" class="btn btn-outline blue btn-sm {{date("d/m",strtotime($e->end_probationary_coefficient)) === date("d/m")? 'active' :'' }}">{{trans('index.probationary')}}</button>                                                   
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                        @endforeach
                                        @else
                                        <h2>{{trans('index.not')}}</h2>
                                        @endif
                                            </div>
                                </div>
                            </div>
                            <!-- END PORTLET-->
                        </div>                          
                    </div>
                    <!-- END DASHBOARD STATS 1-->
                    
                    
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
        <script src="{{url('public/addon/admin/scripts/index.js')}}" type="text/javascript"></script>
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