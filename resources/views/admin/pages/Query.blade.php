<!DOCTYPE html>
@extends('admin.layouts.default')   
@section('title')        
<title>EPOS Shopping | {{trans('index.title')}}</title>
@stop
@section('extra_css')
   
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
                                <span class="caption-subject font-purple bold uppercase">{{trans('menu.query')}}</span>
                            </div>
                            <div class="pull-right">
                                <a class="btn default blue-stripe select tooltips" >Select</a>
                                <a class="btn default yellow-stripe insert tooltips">Insert</a>
                                <a class="btn default red-stripe update tooltips" >Update</a>
                                <a class="btn default dark-stripe delete tooltips">Delete</a>  
                                <a class="btn default green-stripe truncate tooltips">Truncate</a>
                              </div>                           
                        </div>  
                        <div class="portlet-body query-form">
                            <div id="notification"></div>
                             <textarea class="form-control" name="query"></textarea>
                             <div class="tr-space"></div>
                             <button type="button" class="btn dark btn-outline sbold uppercase start">{{trans('global.start')}}</button>
                             <button type="button" class="btn green-haze btn-outline sbold uppercase clear">{{trans('global.clear')}}</button>
                             <div class="tr-space"></div>
                             <div class="table-scrollable hidden">
                                        <table class="table table-hover">
                                            <thead>
                                                <tr>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                
                                            </tbody>
                                        </table>
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
      <script src="{{ url('public/addon/admin/scripts/query.js')}}" type="text/javascript"></script>
        @stop      