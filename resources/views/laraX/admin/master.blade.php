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
    <title>{{ $pageTitle or 'LaraX' }} | Admin dashboard</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1" name="viewport"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta content="Admin dashboard - Tedozi CMS" name="description"/>
    <meta content="" name="author"/>

    <!-- OTHER PLUGINS -->
    @yield('css')
    @include('admin/_shared/_header-css-js')
    <link rel="shortcut icon" href="/images/logo/favicon.png"/>

    <script type="text/javascript">
        var baseUrl = '{{ asset('') }}';
        var fileManagerUrl = '{{ asset($adminPath.'/files/file-manager') }}';
    </script>

</head>

<body class="page-header-fixed page-container-bg-solid page-content-white on-loading {{ $bodyClass or '' }}">

<!-- Loading state -->
<div class="page-spinner-bar">
    <div class="bounce1"></div>
    <div class="bounce2"></div>
    <div class="bounce3"></div>
</div>
<!-- Loading state -->

<!-- BEGIN HEADER -->
<div class="page-header navbar navbar-fixed-top">
    @include('admin/_shared/_header')
</div>
<!-- END HEADER -->

<!-- BEGIN HEADER & CONTENT DIVIDER -->
<div class="clearfix"></div>
<!-- END HEADER & CONTENT DIVIDER -->

<!-- BEGIN CONTAINER -->
<div class="page-container">
    <!-- BEGIN SIDEBAR -->
    <div class="page-sidebar-wrapper">
        @include('admin/_shared/_sidebar')
    </div>
    <!-- END SIDEBAR -->

    <!-- BEGIN CONTENT -->
    <div class="page-content-wrapper">
        <!-- BEGIN CONTENT BODY -->
        <div class="page-content">
            <!-- BEGIN ACTUAL CONTENT -->
            @include('admin/_shared/_breadcrumb-and-page-title')
            @if (session()->has('message'))
                <div class="alert alert-info">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>

                    {!! session('message') !!}
                </div>
            @endif
            <div class="fade-in-up">
                @yield('content')
            </div>
            <!-- END ACTUAL CONTENT -->
        </div>
        <!-- END CONTENT BODY -->
    </div>
    <!-- END CONTENT -->
</div>
<!-- END CONTAINER -->

<!-- BEGIN FOOTER -->
<div class="page-footer">
    @include('admin/_shared/_footer')
</div>
<!-- END FOOTER -->

<!--Modals-->
@include('admin/_shared/_modals')
@include('admin/_shared/_body-js')
<!-- OTHER PLUGINS -->
@yield('js')
<!-- JS INIT -->
@yield('js-init')
<!-- JS INIT -->

<!-- Flash Message -->
@include('admin/_shared/_flash-messages')
<!-- End Flash Message -->
</body>

</html>
