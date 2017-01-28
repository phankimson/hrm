<!DOCTYPE html>
@extends('admin.layouts.default')   
@section('title')        
<title>EPOS HRM | {{trans('index.title')}}</title>
@stop
@section('extra_css')
        <!-- BEGIN PAGE LEVEL PLUGINS -->
        <link href="{{url('public/global/plugins/datatables/datatables.min.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{url('public/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{url('public/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css')}}" rel="stylesheet" type="text/css" />
        <!-- END PAGE LEVEL PLUGINS -->        
@stop    
@section('content')
            <!-- BEGIN CONTENT -->
            <div class="page-content-wrapper">
                <!-- BEGIN CONTENT BODY -->
            <div class="page-content">
                <div id="add_modal" >    
    <!-- /.modal-content -->
                <div id="context-menu">
                         <ul class="dropdown-menu pull-left" role="menu">
                                  <li>
                                        <a href="#" name="add" data-id="1">
                                            <i class="fa fa-plus"></i> {{trans('global.add')}}</a>
				  </li>
                                  <li>
                                        <a href="#" name="copy" data-id="2">
                                            <i class="fa fa-copy"></i> {{trans('global.copy')}}</a>
				  </li>
                                  <li>
                                        <a href="#" name="edit" data-id="3">
                                            <i class="fa fa-edit"></i> {{trans('global.edit')}}</a>
				  </li>
                                  <li>
                                        <a href="#" name="delete" data-id="4">
                                            <i class="fa fa-times"></i> {{trans('global.delete')}}</a>
				  </li>
				  
			</ul>
		</div>
                <div id="table-menu">
                         <ul class="dropdown-menu pull-left" role="menu">
                                  <li>
                                        <a href="#" name="save" data-id="1">
                                            <i class="fa fa-save"></i> {{trans('global.save')}}</a>
				  </li>
                                  <li>
                                        <a href="#" name="cancel" data-id="2">
                                            <i class="fa fa-ban"></i> {{trans('global.cancel')}}</a>
				  </li>				  
			</ul>
		</div>             
       <div id='action' class='modal fade resizable table-menu' data-backdrop="false" data-focus-on='input:first'>
                    <div class='modal-dialog modal-full'>
                        <div class='modal-content portlet box blue-hoki'>
                            <div class='modal-header portlet-title'>
                                <div id='title' class='caption'>
                                </div>
                                <div class='tools'>
                                    <a class='fullscreen' href='javascript:;' data-original-title='' title=''> </a>
                                    <a class='collapse' href='javascript:;' data-original-title='' title=''> </a>
                                    <a class='config' data-toggle='modal' href='#portlet-config' data-original-title='' title=''> </a>
                                    <a class='reload' href='javascript:;' data-original-title='' title=''> </a>
                                    <button type='button' class='close-big cancel' aria-hidden='true'></button>
                                </div>                                                                                      
                            </div>
                            <div class="modal-body portlet-body" id="form-action">
                                            <table  class="table borderless" style="border-style: none">
                                                <tr>
                                                  <td class="col-xs-1"><label class="control-label">{{trans('help_desk.type')}}</label></td>
                                                  <td class="col-md-2"><select class="form-control input-medium select2me" position="1" name="type" id="type" data-placeholder="{{trans('menu.origin')}}">
                                                                            <option value="0">{{trans('menu.origin')}}</option>
                                                                            <option value="1">{{trans('help_desk.other')}}</option> 
                                                                            <option value="2">{{trans('help_desk.general_question')}}</option>    
                                                                    </select> </td>     
                                                </tr>

                                                <tr>
          
                                                  <td class="col-xs-1"><label class="control-label">{{trans('help_desk.name')}}</label></td>
                                                  <td class="col-md-2"><input type="text" class="form-control input-medium" position="2" maxlength="80" name="name" id="maxlength_defaultconfig"></td>     
                                                </tr>                         
                                          
                                                <tr>
                                      
                                                  <td class="col-xs-1"><label class="control-label">{{trans('help_desk.content')}}</label></td>
                                                  <td class="col-md-2"><textarea name="content" position="3" class="ckeditor"></textarea></td>     
                                                </tr> 
                                              
                                                <tr>
                                        
                                                  <td class="col-xs-1"><label class="control-label">{{trans('menu.active')}}</label></td>
                                                  <td class="col-md-4"><input type="checkbox" name="active" class="form-control make-switch" position="4" checked data-size="medium" data-handle-width="25" data-on-text="<i class='fa fa-check'></i>" data-off-text="<i class='fa fa-times'></i>"></td>     
                                                </tr> 
                                                <tr>                                        
                                                  <td class="col-xs-1"></td>
                                                  <td class="col-md-4"><input type="text" class="form-control hidden" position="5" maxlength="70" name="created_at" id="maxlength_defaultconfig"></td>     
                                                </tr> 
                                                <tr>                                        
                                                  <td class="col-xs-1"></td>
                                                  <td class="col-md-4"><input type="text" class="form-control hidden" position="6" maxlength="70" name="updated_at" id="maxlength_defaultconfig"></td>     
                                                </tr> 
                                            </table>	          
                            </div> 
                            <div class="modal-footer" style=" background-color: #fff;">
                                    <a class="btn default green-stripe save tooltips" data-original-title="Ctrl+S" data-placement="top" data-container="body"><i class="fa fa-save" ></i> {{Lang::get('global.save')}} </a>
                                    <a class="btn default purple-stripe cancel tooltips" data-original-title="Ctrl+C" data-placement="top" data-container="body"><i class="fa fa-ban " ></i> {{Lang::get('global.cancel')}} </a>
                             </div>
                         </div>
                    </div>                   
                </div>
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
                                                        <a class="btn default" href="{{url(session()->get('locale').'/'.session()->get('manage').'/export/help-desk')}}" >{{trans('global.download')}}</a>
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
</div>                
                  <div class="portlet light bordered">
                                <div class="portlet-title tabbable-line">
                                    <div class="caption">
                                        <i class="icon-tag font-purple"></i>
                                        <span class="caption-subject font-purple bold uppercase">{{trans('menu.help-desk')}}</span>
                                    </div>
                                    <div class="pull-right">
                                        <a class="btn default blue-stripe add tooltips" data-original-title="Ctrl+Alt+A" data-placement="top" data-container="body"><i class="fa fa-plus"></i> {{trans('global.add')}} </a>
                                        <a class="btn default yellow-stripe copy tooltips" data-original-title="Ctrl+Alt+X" data-placement="top" data-container="body"><i class="fa fa-copy"></i> {{trans('global.copy')}} </a>
                                        <a class="btn default red-stripe edit tooltips" data-original-title="Ctrl+Alt+E" data-placement="top" data-container="body"><i class="fa fa-edit" ></i> {{trans('global.edit')}} </a>
                                        <a class="btn default dark-stripe delete tooltips" data-original-title="Ctrl+Alt+D" data-placement="top" data-container="body"> <i class="fa fa-times"></i> {{trans('global.delete')}} </a>  
                                         <a class="btn default blue-stripe import tooltips" data-original-title="Ctrl+Alt+I" data-placement="top" data-container="body"> <i class="fa fa-database"></i> {{trans('global.import')}} </a>                                         
                                         <div class="btn-group">
                                        <a class="btn purple" href="javascript:;" data-toggle="dropdown" aria-expanded="false">
                                            <i class="fa fa-cogs"></i> {{trans('global.tools')}} 
                                            <i class="fa fa-angle-down"></i>
                                        </a>
                                        <ul class="dropdown-menu" id="datatable_ajax_tools">
                                           <li>
                                                    <a href="javascript:;" data-action="0" class="tool-action">
                                                        <i class="icon-printer"></i> {{trans('global.print')}} </a>
                                                </li>
                                                <li>
                                                    <a href="javascript:;" data-action="1" class="tool-action">
                                                        <i class="icon-check"></i> {{trans('global.copy')}} </a>
                                                </li>
                                                <li>
                                                    <a href="javascript:;" data-action="2" class="tool-action">
                                                        <i class="icon-doc"></i> {{trans('global.export_pdf')}} </a>
                                                </li>
                                                <li>
                                                    <a href="javascript:;" data-action="3" class="tool-action">
                                                        <i class="icon-paper-clip"></i> {{trans('global.export_excel')}}</a>
                                                </li>
                                                <li>
                                                    <a href="javascript:;" data-action="4" class="tool-action">
                                                        <i class="icon-cloud-upload"></i> {{trans('global.export_csv')}}</a>
                                                </li>
                                                <li class="divider"> </li>
                                                <li>
                                                    <a href="javascript:;" data-action="5" class="tool-action">
                                                        <i class="icon-refresh"></i> {{trans('global.view')}}</a>
                                                </li>
                                                </li>
                                        </ul>
                                        </div>                                       
                                      </div>
                                </div>
                                <div class="portlet-body">                                   
                                    <div class="row">
                                    <div class="col-md-12">
                                            <div class="portlet">
                                                <div class="portlet-title">
                                                    <div class="caption">
                                                        <i class='icon-pin'></i>{{trans('global.list')}}                                                             
                                                    </div>                                                    
                                                    <div class="tools">
                                                        <a href="javascript:;" class="collapse"></a>
                                                        <a href="javascript:;" class="reload"></a>
                                                    </div>
                                                </div>
                                                <div class="portlet-body col-md-12">                                                        
                                                        <table class="table table-striped table-bordered table-hover order-column context-menu" style="border:none" id="grid">
                                                            <thead>
                                                                <tr>
                                                                <th> {{trans('global.no')}}</th>                                                                
                                                                <th> {{trans('help_desk.type')}}</th>  
                                                                <th> {{trans('help_desk.name')}}</th> 
                                                                <th> {{trans('help_desk.content')}}</th>
                                                                <th> {{trans('menu.active')}}</th>  
                                                                <th> {{trans('user.created_at')}}</th>  
                                                                <th> {{trans('user.updated_at')}}</th>  
                                                                </tr>
                                                            </thead>
                                                            <tbody>                                                                                                                            
                                                            </tbody>
                                                        </table>                                                        
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
           EposAdminModal.permission = <?= json_encode(session()->get('permission'));?>;    
           EposAdminModal.data= <?= json_encode($data->toArray());?>;
           EposAdminModal.url = <?= json_encode(['save_url'=>'add/help-desk','delete_url'=>'update/help-desk','import_url'=>'import/help-desk']);?>;
        });   
        </script>
               
        <script src="{{ url('public/addon/admin/scripts/epos-admin-modal.js')}}"></script>
         <!-- BEGIN PAGE LEVEL PLUGINS -->

        <script src="{{url('public/global/scripts/datatable.js')}}" type="text/javascript"></script>
        <script src="{{url('public/global/plugins/datatables/datatables.min.js')}}" type="text/javascript"></script>
        <script src="{{url('public/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js')}}" type="text/javascript"></script>
        <script src="{{url('public/global/plugins/datatables/plugins/bootstrap/page.jumpToData().js')}}" type="text/javascript"></script>

        <script src="{{ url('public/global/plugins/bootstrap-maxlength/bootstrap-maxlength.min.js')}}" type="text/javascript"></script>
        <script src="{{ url('public/global/plugins/shortcuts.js')}}" type="text/javascript"></script>

        <script src="{{ url('public/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js')}}" type="text/javascript"></script>     
        <script src="{{ url('public/global/plugins/ckeditor/ckeditor.js')}}" type="text/javascript"></script>
        <script src="{{ url('public/global/plugins/bootstrap-contextmenu/bootstrap-contextmenu.js')}}" type="text/javascript"></script>
        <!-- END PAGE LEVEL PLUGINS -->
          @stop      