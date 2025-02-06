<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	@include('ckfinder::setup')

    <title>Admin</title>

	<!-- Global stylesheets -->
	<link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet" type="text/css">
	<link href="{{ asset('global_assets/css/icons/icomoon/styles.css')}}" rel="stylesheet" type="text/css">
	<link href="{{ asset('assets/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css">
	<link href="{{ asset('assets/css/bootstrap_limitless.min.css')}}" rel="stylesheet" type="text/css">
	<link href="{{ asset('assets/css/layout.min.css')}}" rel="stylesheet" type="text/css">
	<link href="{{ asset('assets/css/components.min.css')}}" rel="stylesheet" type="text/css">
	<link href="{{ asset('assets/css/colors.min.css')}}" rel="stylesheet" type="text/css">
	<link href="{{ asset('assets/css/custom.css')}}" rel="stylesheet" type="text/css">
    <link type="text/css" rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css">
	<!-- /global stylesheets -->

	<!-- Core JS files -->
	<script src="{{ asset('global_assets/js/main/jquery.min.js')}}"></script>
	<script src="{{ asset('global_assets/js/main/bootstrap.bundle.min.js')}}"></script>
	<script src="{{ asset('global_assets/js/plugins/loaders/blockui.min.js')}}"></script>
	<script src="{{ asset('global_assets/js/plugins/ui/ripple.min.js')}}"></script>
	<!-- /core JS files -->

	<!-- Theme JS files -->
	<script src="{{ asset('global_assets/js/plugins/forms/styling/switchery.min.js')}}"></script>
	<script src="{{ asset('global_assets/js/plugins/ui/prism.min.js')}}"></script>
	<script src="{{ asset('global_assets/js/plugins/forms/selects/select2.min.js')}}"></script>
	<script src="{{ asset('global_assets/js/plugins/forms/styling/uniform.min.js')}}"></script>
	<script src="{{ asset('global_assets/js/plugins/forms/tags/tagsinput.min.js')}}"></script>
	<script src="{{ asset('global_assets/js/plugins/forms/tags/tokenfield.min.js')}}"></script>
	<script src="{{ asset('global_assets/js/plugins/forms/inputs/maxlength.min.js')}}"></script>
	<script src="{{ asset('global_assets/js/plugins/forms/inputs/jquery.inputmask.bundle.min.js')}}"></script>
	<script src="{{ asset('global_assets/js/plugins/notifications/sweet_alert.min.js')}}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
	<script src="{{ asset('ckeditor/ckeditor.js')}}"></script>

	<script src="{{ asset('assets/js/app.js')}}"></script>
	<script src="{{ asset('assets/js/custom.js')}}"></script>
	<!-- /theme JS files -->

</head>

<body class="sidebar-xs">
    @include('admin.partials.navbar')
	<!-- Page content -->
	<div class="page-content">
        @include('admin.partials.sidebar')
		<!-- Main content -->
		<div class="content-wrapper">
			@yield('breadcrumbs')
            @yield('content')
			@include('admin.partials.footer')

		</div>
		<!-- /main content -->

	</div>
	<!-- /page content -->

</body>
</html>