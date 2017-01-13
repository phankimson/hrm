<!DOCTYPE html>
@extends('admin.layouts.default')   
@section('title')        
<title>EPOS HRM | {{trans('index.title')}}</title>
@stop
@section('extra_css')
        <!-- BEGIN PAGE LEVEL PLUGINS -->
        <!-- END PAGE LEVEL PLUGINS -->        
@stop    
@section('content')
            <!-- BEGIN CONTENT -->
            <div class="page-content-wrapper">
                <!-- BEGIN CONTENT BODY -->
            <div class="page-content">
                  <div class="portlet light bordered">
                                <div class="portlet-title tabbable-line">
                                    <div class="caption col-sm-4">
                                        <i class="icon-tag font-purple"></i>
                                        <span class="caption-subject font-purple bold uppercase">{{trans('menu.permission')}}</span>
                                    </div>
                                     <select class="form-control input-medium pull-left" id="user" data-placeholder="Select...">
                                        <option value=""></option>
                                        @foreach($user as $u)
                                        <option value="{{$u->id}}">{{$u->username}}</option>
                                        @endforeach
                                    </select>
                                    <select class="form-control input-medium pull-left" name="type" id="type" data-placeholder="{{trans('menu.admin_page')}}">
                                            <option value="">{{trans('global.all')}}</option>
                                            <option value="0">{{trans('menu.admin_page')}}</option>
                                            <option value="1">{{trans('menu.manager_page')}}</option>
                                            <option value="2">{{trans('menu.frontend_page')}}</option>
                                    </select>    
                                     <div class="action col-sm-3 pull-right">                    
                                    <a class="btn default green-stripe save tooltips" data-original-title="Ctrl+Alt+S" data-placement="top" data-container="body"> <i class="fa fa-save"></i> {{trans('global.save')}} </a>
                                    <a class="btn default purple-stripe cancel tooltips" data-original-title="Ctrl+Alt+C" data-placement="top" data-container="body"> <i class="fa fa-ban"></i> {{trans('global.cancel')}} </a>  
                                  </div>    
                                </div>
                                <div class="portlet-body">
                                    <div id="notification"></div> 
                    <table class="table table-bordered table-striped">
                    <thead>
                    <tr class="filter-all">
                            <th>
                                     {{trans('permission.name')}}
                            </th>
                            <th>
                                     {{trans('global.view')}}
                            </th>
                            <th>
                                     {{trans('global.add')}}
                            </th>
                            <th>
                                     {{trans('global.edit')}}
                            </th>
                            <th>
                                     {{trans('global.delete')}}
                            </th>
                    </tr>
                    </thead>
                    <tbody>
                        <tr class="group filter-all">
                            <td> {{trans('global.all')}}
                            </td>
                            <td>
                                    <input type="checkbox" class="all" name="v">
                            </td>
                            <td>
                                    <input type="checkbox" class="all" name="a">
                            </td>
                            <td>
                                   <input type="checkbox" class="all" name="e">
                            </td>
                            <td>
                                   <input type="checkbox" class="all" name="d">
                            </td>
                        </tr>
                        @foreach($menu->where('parent_id',0) as $m)
                        @if($m->link == '')
                        <tr class="group" data-filter="{{$m->type}}">
                        <td colspan="5" class="bold">{{trans('menu.'.$m['code'])}}</td>                           
                        </tr> 
                        @else
                        <tr class="item" data-filter="{{$m->type}}"  data-group="{{$m->parent_id}}" data-id="{{$m->id}}">
                            <td>
                                     {{trans('menu.'.$m['code'])}}
                            </td>
                            <td>
                                    <input type="checkbox" class="checkbox-item" data-group="v-{{$m->parent_id}}" name="v-{{$m->id}}">
                            </td>
                            <td>
                                    <input type="checkbox" class="checkbox-item" data-group="a-{{$m->parent_id}}" name="a-{{$m->id}}">
                            </td>
                            <td>
                                   <input type="checkbox" class="checkbox-item" data-group="e-{{$m->parent_id}}" name="e-{{$m->id}}">
                            </td>
                            <td>
                                   <input type="checkbox" class="checkbox-item" data-group="d-{{$m->parent_id}}" name="d-{{$m->id}}">
                            </td>
                            </tr>
                        @endif
                        @foreach($menu->where('parent_id',$m->id) as $m1)
                        @if($m1->link =='')
                        <tr class="group" data-filter="{{$m1->type}}" data-id="{{$m1->id}}">
                            <td><a href="javascript:;" class="group_click" data-group="{{$m1->id}}"><i class="fa fa-minus"></i> {{trans('menu.'.$m1['code'])}}</a>
                            </td>
                            <td>
                                    <input type="checkbox" class="checkbox-group" name="v-{{$m1->id}}">
                            </td>
                            <td>
                                    <input type="checkbox" class="checkbox-group" name="a-{{$m1->id}}">
                            </td>
                            <td>
                                   <input type="checkbox" class="checkbox-group" name="e-{{$m1->id}}">
                            </td>
                            <td>
                                   <input type="checkbox" class="checkbox-group" name="d-{{$m1->id}}">
                            </td>
                        </tr>
                        @foreach($menu->where('parent_id',$m1->id) as $m2)
                            <tr class="item" data-filter="{{$m1->type}}"  data-group="{{$m2->parent_id}}" data-id="{{$m2->id}}">
                            <td>
                                     {{trans('menu.'.$m2['code'])}}
                            </td>
                            <td>
                                    <input type="checkbox" class="checkbox-item" data-group="v-{{$m2->parent_id}}" name="v-{{$m2->id}}">
                            </td>
                            <td>
                                    <input type="checkbox" class="checkbox-item" data-group="a-{{$m2->parent_id}}" name="a-{{$m2->id}}">
                            </td>
                            <td>
                                   <input type="checkbox" class="checkbox-item" data-group="e-{{$m2->parent_id}}" name="e-{{$m2->id}}">
                            </td>
                            <td>
                                   <input type="checkbox" class="checkbox-item" data-group="d-{{$m2->parent_id}}" name="d-{{$m2->id}}">
                            </td>
                            </tr>
                        @endforeach
                        @elseif($m1->link !=='')
                         <tr class="group" data-filter="{{$m1->type}}"  data-id="{{$m1->id}}">
                             <td><a href="javascript:;">{{trans('menu.'.$m1['code'])}}</a>
                            </td>
                            <td>
                                    <input type="checkbox" class="checkbox-item" name="v-{{$m1->id}}">
                            </td>
                            <td>
                                    <input type="checkbox" class="checkbox-item" name="a-{{$m1->id}}">
                            </td>
                            <td>
                                   <input type="checkbox" class="checkbox-item" name="e-{{$m1->id}}">
                            </td>
                            <td>
                                   <input type="checkbox" class="checkbox-item" name="d-{{$m1->id}}">
                            </td>
                        </tr>
                        @endif
                        @endforeach  
                        @endforeach
                
                    </tbody>
                    </table>   
                                </div>
                            </div>
                  
                    
            </div>
            <!-- END QUICK SIDEBAR -->
        </div>
        <!-- END CONTAINER -->
        @stop           
        @section('extra_javascript')          
         <!-- BEGIN PAGE LEVEL PLUGINS -->
        <script src="{{ url('public/addon/admin/scripts/permission.js')}}"></script>
        <!-- END PAGE LEVEL PLUGINS -->
          @stop      