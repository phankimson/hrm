<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
    <!--<![endif]-->
    <!-- BEGIN HEAD -->

    <head>
        <meta charset="utf-8" />
        <title>EPOS HRM Control panel | {{trans('lock.title')}}</title>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta content="width=device-width, initial-scale=1" name="viewport" />
        <meta content="Phần mềm quản lý" name="description" />
        <meta content="Phan Kim Sơn" name="author" />
        <!-- BEGIN GLOBAL MANDATORY STYLES -->
        <link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css" />
        <link href="{{url('public/global/plugins/font-awesome/css/font-awesome.min.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{url('public/global/plugins/simple-line-icons/simple-line-icons.min.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{url('public/global/plugins/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{url('public/global/plugins/uniform/css/uniform.default.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{url('public/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css')}}" rel="stylesheet" type="text/css" />
        <!-- END GLOBAL MANDATORY STYLES -->
        <!-- BEGIN PAGE LEVEL PLUGINS -->
        <!-- END PAGE LEVEL PLUGINS -->
        <!-- BEGIN THEME GLOBAL STYLES -->
        <link href="{{url('public/global/css/components.min.css')}}" rel="stylesheet" id="style_components" type="text/css" />
        <link href="{{url('/public/layouts/layout/css/themes/darkblue.min.css')}}" rel="stylesheet" type="text/css" id="style_color" />
        <link href="{{url('public/global/css/plugins.min.css')}}" rel="stylesheet" type="text/css" />
        <!-- END THEME GLOBAL STYLES -->
        <!-- BEGIN PAGE LEVEL STYLES -->
        <link href="{{url('public/pages/css/lock.min.css')}}" rel="stylesheet" type="text/css" />
        <!-- END PAGE LEVEL STYLES -->
        <!-- BEGIN THEME LAYOUT STYLES -->
        <!-- END THEME LAYOUT STYLES -->
        <link rel="shortcut icon" href="{{url('public/global/img/icon.png')}}" /> </head>
    <!-- END HEAD -->
    
      <body class="">
        <div class="page-lock">
            <div class="page-logo">
                <a class="brand" href="index">
                    <img src="{{url('public/global/img/logo-big.png')}}" alt="logo" /> </a>
            </div>
            <div class="page-body">
                <div class="lock-head"> {{trans('lock.locked')}} </div>
                <div class="lock-body">
                    <div class="pull-left lock-avatar-block">
                        <img src="{{$avatar}}" class="lock-avatar"> </div>
                    <form class="lock-form pull-left">
                        <div id="notification"></div>
                        <h4>{{$user}}</h4>
                        <div class="form-group">
                            <input class="form-control placeholder-no-fix" type="password" autocomplete="off" placeholder="{{trans('login.password')}}" name="password" /> </div>
                        <div class="form-actions">
                            <button type="submit" id="btn-login-lock" class="btn red uppercase">{{trans('login.submit')}}</button>
                        </div>
                    </form>
                </div>
                <div class="lock-bottom">
                    <a href="">{{trans('lock.not')}} {{$user}} ?</a>
                </div>
            </div>
            <div class="page-footer-custom">  2016 &copy; EPOS group. </div>
        </div>   

        <!--[if lt IE 9]>
<script src="../assets/global/plugins/respond.min.js"></script>
<script src="../assets/global/plugins/excanvas.min.js"></script> 
<![endif]-->
        <!-- BEGIN CORE PLUGINS -->
        <script src="{{url('public/global/plugins/jquery.min.js')}}" type="text/javascript"></script>
        <script src="{{url('public/global/plugins/bootstrap/js/bootstrap.min.js')}}" type="text/javascript"></script>
        <script src="{{url('public/global/plugins/js.cookie.min.js')}}" type="text/javascript"></script>
        <script src="{{url('public/global/plugins/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js')}}" type="text/javascript"></script>
        <script src="{{url('public/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js')}}" type="text/javascript"></script>
        <script src="{{url('public/global/plugins/jquery.blockui.min.js')}}" type="text/javascript"></script>
        <script src="{{url('public/global/plugins/uniform/jquery.uniform.min.js')}}" type="text/javascript"></script>
        <script src="{{url('public/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js')}}" type="text/javascript"></script>
        <!-- END CORE PLUGINS -->       
        <!-- BEGIN THEME GLOBAL SCRIPTS -->
        <script src="{{url('public/global/scripts/app.min.js')}}" type="text/javascript"></script>
        <!-- END THEME GLOBAL SCRIPTS -->
        <!-- BEGIN PAGE LEVEL SCRIPTS -->
        <script src="{{url('public/addon/admin/scripts/lock.js')}}" type="text/javascript"></script>
        <script src="{{url('public/addon/global/scripts/framework.js')}}" type="text/javascript"></script>
        <!-- END PAGE LEVEL SCRIPTS -->
        <!-- BEGIN THEME LAYOUT SCRIPTS -->
        <!-- END THEME LAYOUT SCRIPTS -->
        <script>
        jQuery(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
        });
</script>
    </body>

</html>