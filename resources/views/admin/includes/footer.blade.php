<!-- BEGIN FOOTER -->
        <div class="page-footer">
            <div class="page-footer-inner"> 2016 &copy; EPOS group.                  
            </div>
            <div class="scroll-to-top">
                <i class="icon-arrow-up"></i>
            </div>
        </div>
        <!-- END FOOTER -->
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
        <script src="{{ url('public/global/plugins/bootbox/bootbox.min.js')}}" type="text/javascript"></script>
        <script src="{{url('public/global/plugins/select2/js/select2.full.min.js')}}" type="text/javascript"></script>
        <!-- END CORE PLUGINS -->
       
       <!-- BEGIN THEME GLOBAL SCRIPTS -->
        <script src="{{url('public/global/scripts/app.min.js')}}" type="text/javascript"></script>
        <!-- END THEME GLOBAL SCRIPTS -->        
      
         <!-- BEGIN THEME LAYOUT SCRIPTS -->
        <script src="{{url('public/layouts/layout/scripts/layout.min.js')}}" type="text/javascript"></script>
        <script src="{{url('public/layouts/layout/scripts/demo.min.js')}}" type="text/javascript"></script>
        <script src="{{url('public/layouts/global/scripts/quick-sidebar.min.js')}}" type="text/javascript"></script>
        <script src="{{url('public/addon/admin/scripts/config.js')}}" type="text/javascript"></script>
        <script src="{{url('public/addon/global/scripts/framework.js')}}" type="text/javascript"></script>
        <!-- END THEME LAYOUT SCRIPTS -->
         <script>
        $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
        });
        </script>
    </body>

</html>