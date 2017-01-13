<!DOCTYPE html>
@extends('admin.layouts.default')   
@section('title')        
<title>EPOS Shopping | Phần mềm bán hàng siêu thị</title>
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
                  
                  {{trans('messages.you_are_not_permission_view')}}
                    
            </div>
            <!-- END QUICK SIDEBAR -->
        </div>
        @stop           
        @section('extra_javascript')          
         <!-- BEGIN PAGE LEVEL PLUGINS -->

        <!-- END PAGE LEVEL PLUGINS -->
          @stop      