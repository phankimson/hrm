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
    <!-- END PAGE LEVEL PLUGINS -->
    @stop
    @section('content')
            <!-- BEGIN CONTENT -->
    <div class="page-content-wrapper">
        <!-- BEGIN CONTENT BODY -->
        <div class="page-content">
            <div class="modal fade" id="import" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                            <h4 class="modal-title">{{trans('global.import')}}</h4>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <form class="import" enctype="multipart/form-data" role="form" method="post">
                                    <label class="control-label col-md-4">{{trans('global.file')}}</label>
                                    <div class="col-md-5">
                                        <div class="fileinput fileinput-new" data-provides="fileinput">
                                            <div class="input-group input-large">
                                                <div class="form-control uneditable-input" data-trigger="fileinput">
                                                    <i class="fa fa-file fileinput-exists"></i>&nbsp; <span class="fileinput-filename">
                                                                                    </span>
                                                </div>
                                                                            <span class="input-group-addon btn default btn-file">
                                                                            <span class="fileinput-new">
                                                                            {{trans('global.choose')}} </span>
                                                                            <span class="fileinput-exists">
                                                                            {{trans('global.change')}} </span>
                                                                            <input id="file" type="file" name="file">
                                                                            </span>
                                                <a href="#" class="input-group-addon btn red fileinput-exists" data-dismiss="fileinput">
                                                    {{trans('global.cancel')}}</a>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="tr-space"></div>
                            <div class="tr-space"></div>
                            <div class="form-group">
                                <label class="control-label col-md-4">{{trans('global.template')}}</label>
                                <div class="col-md-5">
                                    <a class="btn default" href="{{url(session()->get('locale').'/'.session()->get('manage').'/export/options')}}" >{{trans('global.download')}}</a>
                                </div>
                            </div>
                            <div class="tr-space"></div>
                            <div class="tr-space"></div>
                        </div>
                        <div class="modal-footer">
                            <div id="progress"></div>
                            <a type="button" class="btn blue saveimport">{{trans('global.start')}}</a>
                            <a type="button" class="btn default" data-dismiss="modal">{{trans('global.close')}}</a>
                        </div>
                    </div>
                    <!-- /.modal-content -->
                </div>
            </div>
            <div class="portlet light bordered">
                <div class="portlet-title tabbable-line">
                    <div class="caption">
                        <i class="icon-tag font-purple"></i>
                        <span class="caption-subject font-purple bold uppercase">{{trans('menu.department')}}</span>
                    </div>
                    <div class="pull-right">
                        <a class="btn default blue-stripe add tooltips" data-original-title="Ctrl+Alt+A" data-placement="top" data-container="body"><i class="fa fa-plus"></i> {{trans('global.add')}} </a>
                        <a class="btn default yellow-stripe copy tooltips" data-original-title="Ctrl+Alt+X" data-placement="top" data-container="body"><i class="fa fa-copy"></i> {{trans('global.copy')}} </a>
                        <a class="btn default red-stripe edit tooltips" data-original-title="Ctrl+Alt+E" data-placement="top" data-container="body"><i class="fa fa-edit" ></i> {{trans('global.edit')}} </a>
                        <a class="btn default green-stripe save tooltips" data-original-title="Ctrl+Alt+S" data-placement="top" data-container="body"><i class="fa fa-save" ></i> {{trans('global.save')}} </a>
                        <a class="btn default purple-stripe cancel tooltips" data-original-title="Ctrl+Alt+C" data-placement="top" data-container="body"><i class="fa fa-ban " ></i> {{trans('global.cancel')}} </a>
                        <a class="btn default dark-stripe delete tooltips" data-original-title="Ctrl+Alt+D" data-placement="top" data-container="body"> <i class="fa fa-times"></i> {{trans('global.delete')}} </a>
                        <a class="btn default blue-stripe import tooltips" data-original-title="Ctrl+Alt+I" data-placement="top" data-container="body"> <i class="fa fa-database"></i> {{trans('global.import')}} </a>
                        <div class="btn-group">
                            <a class="btn purple" href="javascript:;" data-toggle="dropdown" aria-expanded="false">
                                <i class="fa fa-print"></i> {{trans('global.print')}}
                                <i class="fa fa-angle-down"></i>
                            </a>
                            <ul class="dropdown-menu" id="datatable_ajax_tools">
                                @foreach($print as $p)
                                    <li>
                                        <a class='printlabor' href="#{{$p->code}}">{{$p->name}}</a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="portlet-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="portlet">
                                <div class="portlet-title">
                                    <div class="caption">
                                        <i class='icon-pin'></i>{{trans('global.list')}}
                                    </div>
                                    <div class="dataTables_filter col-md-6 col-sm-12">
                                        <label>
                                            {{trans('global.search')}}:
                                            <input class="form-control input-small input-inline" type="search" placeholder="" id="searchbox-grid">
                                        </label>
                                    </div>
                                    <div class="tools">
                                        <a href="javascript:;" class="collapse"></a>
                                        <a href="javascript:;" class="reload"></a>
                                    </div>
                                </div>
                                <div class="portlet-body table-both-scroll">
                                    <table class="table table-striped table-bordered table-hover order-column" style="border:none" id="grid">
                                        <thead>
                                        <tr>
                                            <th> {{trans('global.no')}}</th>
                                            <th> {{trans('labor_contact.code')}}</th>
                                            <th> {{trans('labor_contact.employee')}}</th>
                                            <th> {{trans('labor_contact.contact_date')}}</th>
                                            <th> {{trans('labor_contact.contact_end')}}</th>
                                            <th> {{trans('menu.active')}}</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="portlet">
                                <div class="portlet-title">
                                    <div class="caption">
                                        <i class='icon-pin'></i>
                                        <span id="oper"></span>
                                    </div>
                                    <div class="tools">
                                        <a href="javascript:;" class="collapse"></a>
                                        <a href="javascript:;" class="reload"></a>
                                    </div>
                                </div>
                                <div class="portlet-body" id='form-action'>
                                    <div id="notification"></div>
                                    <div class="form-group">
                                        <label class="col-sm-4 control-label">{{trans('labor_contract.date')}}</label>
                                        <div class="input-group input-large date-picker input-daterange" data-date-format="dd/mm/yyyy" data-date="10/11/2012">
                                            <input class="form-control date-picker date" type="text"  position="3" name="contract_date">
                                            <span class="input-group-addon"> to </span>
                                            <input class="form-control date-picker date" type="text"  position="4" name="contract_end">
                                        </div>
                                    </div>
                                    <div class="tr-space"></div>
                                    <div class="tr-space"></div>
                                    <div class="form-group">
                                        <label class="col-sm-4 control-label">{{trans('labor_contract.code')}} (*)</label>
                                        <div class="col-sm-5">
                                            <input type="text" class="form-control input-large not-null" position="1" maxlength="50" name="code" id="maxlength_defaultconfig">
                                        </div>
                                    </div>
                                    <div class="tr-space"></div>
                                    <div class="tr-space"></div>
                                    <div class="form-group">
                                        <label class="col-sm-4 control-label">{{trans('employee.name')}} (*)</label>
                                        <div class="col-sm-5">
                                            <select class="form-control input-large select2me" position="2" name="employee_id" id="employee_id" data-placeholder="Select...">
                                                <option value=""></option>
                                                @foreach($employee as $e)
                                                    <option value="{{$e['id']}}">{{$e['fullname']}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="tr-space"></div>
                                    <div class="tr-space"></div>
                                    <div class="form-group">
                                        <label class="col-sm-4 control-label">{{trans('menu.active')}}</label>
                                        <div class="col-md-4">
                                            <input type="checkbox" name="active" class="form-control make-switch"  position="5" checked data-on-text="<i class='fa fa-check'></i>" data-off-text="<i class='fa fa-times'></i>">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


        </div>
        <!-- END QUICK SIDEBAR -->
    </div>
    <!-- END CONTAINER -->
@stop
@section('extra_javascript')
    <script>
        jQuery(document).ready(function() {
            EposAdmin.permission = <?= json_encode(session()->get('permission'));?>;
            EposAdmin.data= <?= json_encode($data->toArray());?>;
            EposAdmin.url = <?= json_encode(['save_url'=>'add/timekeeper','delete_url'=>'update/timekeeper','import_url'=>'import/timekeeper']);?>;
        });
    </script>

    <script src="{{ url('public/addon/admin/scripts/epos-admin.js')}}"></script>
    <!-- BEGIN PAGE LEVEL PLUGINS -->
    <script src="{{url('public/global/plugins/select2/js/select2.full.min.js')}}" type="text/javascript"></script>

    <script src="{{url('public/global/scripts/datatable.js')}}" type="text/javascript"></script>
    <script src="{{url('public/global/plugins/datatables/datatables.min.js')}}" type="text/javascript"></script>
    <script src="{{url('public/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js')}}" type="text/javascript"></script>

    <script src="{{ url('public/global/plugins/bootstrap-maxlength/bootstrap-maxlength.min.js')}}" type="text/javascript"></script>
    <script src="{{ url('public/global/plugins/shortcuts.js')}}" type="text/javascript"></script>

    <script src="{{ url('public/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js')}}" type="text/javascript"></script>
    <script src="{{ url('public/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js')}}" type="text/javascript"></script>
    <script src="{{ url('public/pages/scripts/components-date-time-pickers.js')}}" type="text/javascript"></script>

    <!-- END PAGE LEVEL PLUGINS -->
@stop