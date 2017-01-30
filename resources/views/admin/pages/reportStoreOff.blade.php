<!DOCTYPE html>
@extends('admin.layouts.default')   
@section('title')        
<title>EPOS Shopping | {{trans('index.title')}}</title>
@stop
@section('extra_css')
      <!-- BEGIN PAGE LEVEL PLUGINS -->
        <link href="{{url('public/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{url('public/global/plugins/bootstrap-daterangepicker/daterangepicker.min.css')}}" rel="stylesheet" type="text/css" />   
        <link href="{{url('public/global/plugins/bootstrap-table/src/bootstrap-table.css')}}" rel="stylesheet" type="text/css" />   
@stop    
@section('content')
            <!-- BEGIN CONTENT -->
            <div class="page-content-wrapper">
                <!-- BEGIN CONTENT BODY -->
                <div class="page-content">
                    <div class="portlet light bordered">
                        <div class="portlet-title tabbable-line">
                            <div class="caption">
                                <i class="icon-tag font-purple"></i>
                                <span class="caption-subject font-purple bold uppercase">{{trans('menu.report-store-off')}}</span>
                            </div> 
                             <a href="javascript:;" class="btn blue-hoki pull-right" style="display: none" id="btn-show"> {{trans('global.show')}}
                                            <i class="fa fa-sort-down"></i>
                                        </a>    
                        </div>  
                        <div class="portlet-body query-form">
                            <div class="tabbable-line">
                            <div class="row" id="data-crit">
                            <div id="notification"></div>
                            <div class="form-group">
                                    <label class="col-sm-4 control-label">{{trans('store_off.name')}}</label>
                                    <div class="col-sm-5">                       
                                   <select name="name" id="name" data-placeholder="All"  class="input-medium form-control select2me"> 
                                    <option value=""></option>
                                    <option value="1">{{trans('store_off.al')}}</option>
                                    <option value="2">{{trans('store_off.cl')}}</option>
                               </select>
                                   </div>
                                </div> 
                             <div class="tr-space"></div>
                            <div class="tr-space"></div>
                            <div class="form-group">
                                <label class="control-label col-sm-4">{{trans('department.name')}}</label>
                                 <div class="col-sm-5">
                                <select class="form-control input-large select2me" name="department_id" id="department_id">
                                <option value="">{{trans('global.all')}}</option>
                                @foreach($department as $p)
                                <option value="{{$p->id}}">{{$p->name}}</option>
                                @endforeach                               
                                </select>  
                                 </div>
                            </div>  
                            <div class="tr-space"></div>
                            <div class="tr-space"></div>
                            <div class="form-group">
                                <label class="control-label col-sm-4">{{trans('period.name')}}</label>
                                 <div class="col-sm-5">
                                <select class="form-control input-large select2me" name="period_id" id="period_id">
                                <option value="">{{trans('global.all')}}</option>
                                @foreach($period as $p)
                                <option value="{{$p->id}}">{{$p->name}}</option>
                                @endforeach                               
                                </select>  
                                 </div>
                            </div>    
                            <div class="tr-space"></div>
                            <div class="tr-space"></div>
                            <div class="form-group">
                                <label class="control-label col-sm-4">{{trans('employee.name')}}</label>
                                <div class="col-sm-5">
                                <select class="form-control input-large select2me" name="employee_id" id="employee_id">
                                <option value="">{{trans('global.all')}}</option>
                                @foreach($employee as $p)
                                <option value="{{$p->id}}">{{$p->fullname}}</option>
                                @endforeach     
                                </select>  
                                </div>
                            </div>                          
                            <div class="tr-space"></div>
                            <div class="tr-space"></div>
                                <div class="form-group">
                                     <label class="control-label col-sm-4"></label>
                                      <div class="col-sm-5">
                                        <a href="javascript:;" class="btn red" id="btn-search"> {{trans('global.search')}}
                                            <i class="fa fa-search"></i>
                                        </a>
                                       <a href="javascript:;" class="btn purple"  id="btn-hide"> {{trans('global.hide')}}
                                            <i class="fa fa-sort-up"></i>
                                        </a>                                      
                                      </div> 
                                 </div> 
                            </div>     
                            <div class="row" id="data-table">
                               <table id="table"    
                                data-toggle="table"
                                data-unique-id="id"          
                                data-show-export="true"
                                data-pagination="true"
                                data-click-to-select="true"
                                data-filter-control="true"
                                data-filter-show-clear="true"
                                data-toolbar="#toolbar"
                                data-search="true"
                                data-show-footer="true"
                                data-show-refresh="true"
                                data-show-toggle="true"
                                data-show-print="true"
                                data-show-columns="true">
                             <thead>
                                <tr>
                                    <th data-formatter="runningFormatter">#</th>
                                    <th data-field="code" data-sortable="true" data-filter-control="input" >{{trans('employee.code')}}</th>
                                    <th data-field="name" data-footer-formatter="totalTextFormatter" data-sortable="true" data-filter-control="input">{{trans('employee.fullname')}}</th>
                                    <th data-field="position" data-sortable="true" data-filter-control="select" >{{trans('employee.position')}}</th>
                                    <th data-field="department" data-sortable="true" data-filter-control="select" >{{trans('employee.department')}}</th>                            
                                    <th data-field="opening_stock_quantity" data-footer-formatter="sumFormatter" data-formatter="priceFomatter" data-sortable="true" data-filter-control="input" data-align="right">{{trans('store_off.open')}}</th>                                   
                                    <th data-field="receipt_stock_quantity" data-footer-formatter="sumFormatter" data-formatter="priceFomatter"  data-sortable="true" data-filter-control="input" data-align="right">{{trans('store_off.up')}}</th>
                                    <th data-field="issue_stock_quantity" data-footer-formatter="sumFormatter" data-formatter="priceFomatter"  data-sortable="true" data-filter-control="input" data-align="right">{{trans('store_off.down')}}</th>
                                    <th data-field="closing_stock_quantity" data-footer-formatter="sumFormatter" data-formatter="priceFomatter"  data-sortable="true" data-filter-control="input" data-align="right">{{trans('store_off.close')}}</th>
                                </tr>
                             </thead>
                         </table> 
                            </div>
                          </div>  
                        </div>
                    </div>
                </div>
                <!-- END CONTENT BODY -->
            </div>
            <!-- END CONTENT -->
         
        </div>
        <!-- END CONTAINER -->
        @stop           
        @section('extra_javascript')     
          <script>
        jQuery(document).ready(function() {   
           EposReport.data= <?= json_encode($data->toArray());?>;   
           EposReport.url= <?= json_encode(['search_url'=>'get/report-store-off']);?>;
        });   
        </script>         
        <script src="{{url('public/addon/admin/scripts/epos-report-stock.js')}}" type="text/javascript"></script>
         <!-- BEGIN PAGE LEVEL PLUGINS -->
        
        <script src="{{url('public/global/plugins/moment.min.js')}}" type="text/javascript"></script>
        <script src="{{url('public/global/plugins/bootstrap-daterangepicker/daterangepicker.min.js')}}" type="text/javascript"></script>

        <script src="{{ url('public/global/plugins/bootstrap-maxlength/bootstrap-maxlength.min.js')}}" type="text/javascript"></script>
        <script src="{{ url('public/global/plugins/shortcuts.js')}}" type="text/javascript"></script>

        <script src="{{ url('public/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js')}}" type="text/javascript"></script>
        <script src="{{ url('public/global/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js')}}" type="text/javascript"></script>
        <script src="{{ url('public/global/plugins/jquery-number-master/jquery.number.min.js')}}" type="text/javascript"></script>  
        
        <script src="{{ url('public/global/plugins/bootstrap-table/src/bootstrap-table.js')}}" type="text/javascript"></script>  
        <script src="{{ url('public/global/plugins/bootstrap-table/src/extensions/export/bootstrap-table-export.js')}}" type="text/javascript"></script>  
        <script src="{{ url('public/global/plugins/bootstrap-table/src/extensions/export/tableExport.js')}}" type="text/javascript"></script> 
        <script src="{{ url('public/global/plugins/bootstrap-table/src/extensions/filter-control/bootstrap-table-filter-control.js')}}" type="text/javascript"></script> 
        <script src="{{ url('public/global/plugins/bootstrap-table/src/extensions/print/bootstrap-table-print.js')}}" type="text/javascript"></script>
        @stop      