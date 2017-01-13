<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="vn">
<!--<![endif]-->

<!-- Head BEGIN -->
<head>
    @include('admin.includes.head')
    @yield('extra_css')
    @yield('title')
  <!-- Theme styles END -->
</head>
<!-- Body BEGIN -->
<body class="page-header-fixed page-sidebar-closed-hide-logo page-content-white">
<!-- Head END -->
@include('admin.includes.header')
@include('admin.includes.menu')
@yield('content')

@include('admin.includes.footer')

@yield('extra_javascript')
@include('languages')
</body>
<!-- END BODY -->
</html>