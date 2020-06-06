<!doctype html>
<html lang="en">

<head>
	<title>Dashboard | Klorofil - Free Bootstrap Dashboard Template</title>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
	<!-- VENDOR CSS -->
	<link rel="stylesheet" href="{{asset('admin/assets/vendor/bootstrap/css/bootstrap.min.css')}}">
	<link rel="stylesheet" href="{{asset('admin/assets/vendor/font-awesome/css/font-awesome.min.css')}}">
	<link rel="stylesheet" href="{{asset('admin/assets/vendor/linearicons/style.css')}}">
	<link rel="stylesheet" href="{{asset('admin/assets/vendor/chartist/css/chartist.min.css')}}">
	<!-- MAIN CSS -->
	<link rel="stylesheet" href="{{asset('admin/assets/css/main.css')}}">
	<!-- FOR DEMO PURPOSES ONLY. You should remove this in your project -->
	<link rel="stylesheet" href="{{asset('admin/assets/css/demo.css')}}">
	<link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css">
	<!-- GOOGLE FONTS -->
	<link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700" rel="stylesheet">
	<!-- ICONS -->
	<link rel="apple-touch-icon" sizes="76x76" href="{{asset('admin/assets/img/apple-icon.png')}}">
	<link rel="icon" type="image/png" sizes="96x96" href="{{asset('admin/assets/img/favicon.png')}}">
    <style>
        .ct-label {
            font-size: 14px;
        }
    </style>
</head>

<body>
	<!-- WRAPPER -->
	<div id="wrapper">
		<!-- NAVBAR -->
		@include('layouts.includes._navbar')
		<!-- END NAVBAR -->
		<!-- LEFT SIDEBAR -->
		@include('layouts.includes._sidebar')
		<!-- END LEFT SIDEBAR -->
		<!-- MAIN -->
		@yield('content')
		<!-- END MAIN -->
		<div class="clearfix"></div>
		<footer>

		</footer>
	</div>
	<!-- END WRAPPER -->
	<!-- Javascript -->
	<script src="/user/js/jquery-3.3.1.min.js"></script>
	<script src="/user/js/bootstrap.min.js"></script>
	<script src="/user/js/jquery-ui.min.js"></script>
	<script src="/user/js/jquery.countdown.min.js"></script>
	<script src="/user/js/jquery.nice-select.min.js"></script>
	<script src="/user/js/jquery.zoom.min.js"></script>
	<script src="/user/js/jquery.dd.min.js"></script>
	<script src="/user/js/jquery.slicknav.js"></script>
	<script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js">

	</script>
	<script src="/user/js/owl.carousel.min.js"></script>
    <script src="/user/js/main.js"></script>
    <script src="{{ asset('admin/assets/vendor/chartist/js/chartist.min.js') }}"></script>
    @yield('script')
</body>
<script type="text/javascript">
$(document).ready(function() {
    $('#example').DataTable( {
    pageLength : 5,
    lengthMenu: [[5, 10, 20, -1], [5, 10, 20, 100]]
  } );
} );

</script>
</html>
