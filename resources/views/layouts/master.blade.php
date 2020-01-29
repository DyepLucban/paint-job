<!DOCTYPE html>
<html>
<head>
	<title>Paint Jobs</title>
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	<style type="text/css">
		.jumbotron {
			margin-bottom: 0 !important;
		}
		.nav > li > a:hover{
    		color: black;
		}
		.nav > li > a{
    		color: white;
		}
		.active {
			color: black !important;
		}
	</style>
</head>
<body>
	<div class="container">
		@yield('content')
	</div>
</body>
	<script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
	<script type="text/javascript" src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
	@yield('javascript')
</html>