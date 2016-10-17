<!DOCTYPE html>
<!--[if IE 8]>
<html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]>
<html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
<!--<![endif]-->
<head>
    <meta charset="utf-8"/>
    <title>{!! $pageTitle or 'Login' !!} | Admin dashboard</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1" name="viewport"/>
    <meta name="csrf-token" content="{!! csrf_token() !!}">
    <meta content="Admin dashboard - Tedozi CMS" name="description"/>
    <meta content="" name="author"/>

    <!-- OTHER PLUGINS -->
    @yield('css')
    <!-- END OTHER PLUGINS -->
    @include('admin/_shared/_header-css-js')
    <link rel="shortcut icon" href="admin/favicon.ico"/>

    <script type="text/javascript">
        var baseUrl = '{{ asset('') }}';
    </script>

</head>

<body class="page-header-fixed page-content-white login page-auth">

<!-- Loading state -->
<div class="page-spinner-bar">
    <div class="bounce1"></div>
    <div class="bounce2"></div>
    <div class="bounce3"></div>
</div>
<!-- Loading state -->

<div class="menu-toggler sidebar-toggler"></div>
<!-- END SIDEBAR TOGGLER BUTTON -->
<!-- BEGIN LOGO -->
<div class="logo">
    <a href="/">
        <img src="{{Theme::url('admin/theme/images/logo.png')}}" alt=""/> </a>
</div>
<!-- END LOGO -->
<!-- BEGIN LOGIN -->
<div class="content">
    @yield('content')
</div>
<div class="copyright">2016 &copy; LaraX. All rights reserved.</div>

@include('admin/_shared/_body-js')

<!-- OTHER PLUGINS -->
@yield('js')
<!-- END OTHER PLUGINS -->

<!-- JS INIT -->
@yield('js-init')
<!-- JS INIT -->

@include('admin/_shared/_flash-messages')

</body>

</html>
