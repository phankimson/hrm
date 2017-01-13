<!DOCTYPE html>
@extends('admin.layouts.default')   
@section('title')        
<title>EPOS HRM | {{trans('index.title')}}</title>
@stop
@section('extra_css')
        <!-- BEGIN PAGE LEVEL PLUGINS -->
        <link href="{{url('public/global/plugins/select2/css/select2.min.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{url('public/global/plugins/select2/css/select2-bootstrap.min.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{url('public/global/plugins/datatables/datatables.min.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{url('public/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{url('public/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{url('public/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{url('public/global/plugins/handsontable/dist/pro/handsontable.full.min.css')}}" rel="stylesheet" type="text/css" />
        <!-- END PAGE LEVEL PLUGINS -->          
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
                                <span class="caption-subject font-purple bold uppercase">{{trans('menu.timesheet')}}</span>
                            </div> 
                             <a href="javascript:;" class="btn blue-hoki pull-right" style="display: none" id="btn-show"> {{trans('global.show')}}
                                            <i class="fa fa-sort-down"></i>
                                        </a>    
                            <div class="pull-right">
                                        <a class="btn default blue-stripe add tooltips" data-original-title="Ctrl+Alt+A" data-placement="top" data-container="body"><i class="fa fa-plus"></i> {{trans('global.add')}} </a>
                    <!--      <a class="btn default yellow-stripe copy tooltips" data-original-title="Ctrl+Alt+X" data-placement="top" data-container="body"><i class="fa fa-copy"></i> {{trans('global.copy')}} </a>-->
                          <a class="btn default red-stripe edit tooltips" data-original-title="Ctrl+Alt+E" data-placement="top" data-container="body"><i class="fa fa-edit" ></i> {{trans('global.edit')}} </a>
                          <a class="btn default green-stripe save tooltips" data-original-title="Ctrl+Alt+S" data-placement="top" data-container="body"> <i class="fa fa-save"></i> {{trans('global.save')}} </a>
                          <a class="btn default purple-stripe cancel tooltips" data-original-title="Ctrl+Alt+C" data-placement="top" data-container="body"> <i class="fa fa-cancel"></i> {{trans('global.cancel')}} </a>
                          <a class="btn default red-stripe delete tooltips" data-original-title="Ctrl+Alt+D" data-placement="top" data-container="body"> <i class="fa fa-times"></i> {{trans('global.delete')}} </a> 
                          <a class="btn default red-stripe print tooltips" data-original-title="Ctrl+Alt+P" data-placement="top" data-container="body"> <i class="fa fa-print"></i> {{trans('global.print')}} </a>
                          <a class="btn default yellow-stripe total" data-original-title="Ctrl+Alt+T" data-placement="top" data-container="body"> <i class="fa fa-tag"></i> {{trans('timesheet.total')}} </a>                                      
                                      </div>                            
                        </div>  
                        <div class="portlet-body query-form">                                                             
                            <div class="row" id="data-crit">
                            <div id="notification"></div>                            
                              <div class="form-group row col-md-offset-3">
                                <label class="col-sm-4 control-label">{{trans('menu.period')}} (*)</label>
                                <div class="col-md-4">
                                   <select name="period_id" id="period_id" data-placeholder="All"  class="input-medium form-control select2me select2-check"> 
                                       <option value=""></option>
                                       @foreach($period as $p)
                                       <option {{$p->lock==1?'disabled':''}}disabled value="{{$p['id']}}">{{$p['name']}}</option>
                                       @endforeach
                                  </select>
                                </div>
                              </div>
                            <div class="form-group row col-md-offset-3">
                            <label class="col-sm-4 control-label">{{trans('menu.department')}}</label>
                                <div class="col-md-4">
                                   <select name="department_id" id="department_id" data-placeholder="All" class="input-medium form-control select2me" multiple="multiple"> 
                                       @foreach($department as $value)
                                               <option value="{{$value['id']}}">{{$value['name']}}</option>
                                       @endforeach
                                  </select>
                                </div>
                            </div>                            
                            </div>     
                            <div class="row">
                                 <div id="table-excel" class="handsontable-excel" style="display: none;width: 100%; overflow:auto"></div>      
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
           EposHand.permission = <?= json_encode(session()->get('permission'));?>; 
           EposHand.url = <?= json_encode(['load_url'=>'get/timesheet','delete_url'=>'update/timesheet','save_url'=>'add/timesheet']);?>;
        });  
        </script>         
        <script src="{{ url('public/addon/admin/scripts/epos-hand.js')}}"></script>
         <!-- BEGIN PAGE LEVEL PLUGINS -->
        <script src="{{url('public/global/plugins/select2/js/select2.full.min.js')}}" type="text/javascript"></script>

        <script src="{{url('public/global/scripts/datatable.js')}}" type="text/javascript"></script>
        <script src="{{url('public/global/plugins/datatables/datatables.min.js')}}" type="text/javascript"></script>
        <script src="{{url('public/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js')}}" type="text/javascript"></script>

        <script src="{{ url('public/global/plugins/bootstrap-maxlength/bootstrap-maxlength.min.js')}}" type="text/javascript"></script>
        <script src="{{ url('public/global/plugins/shortcuts.js')}}" type="text/javascript"></script>
        <script src="{{ url('public/global/plugins/jquery.print.js')}}" type="text/javascript"></script>

        <script src="{{ url('public/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js')}}" type="text/javascript"></script>    
        <script src="{{ url('public/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js')}}" type="text/javascript"></script>
        <script src="{{ url('public/global/plugins/handsontable/dist/pro/handsontable.full.min.js')}}" type="text/javascript"></script>
        <script src="{{ url('public/global/plugins/handsontable/dist/select2-editor.js')}}" type="text/javascript"></script>
        @stop      