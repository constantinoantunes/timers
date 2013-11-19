<!doctype html>
<html lang="en">
	<head>
	    <title>Timers</title>
   	    <meta charset="UTF-8">
	    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css"/>
	    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap-theme.min.css"/>
		<style type="text/css">
		.container {
			width: 400px;
			margin: 20px auto;
		}
		</style>
	</head>
	<body>
		<div class="container">
		@yield('content')
		</div>
		
	    <script type="text/javascript" src="assets/jquery-1.10.2.min.js"></script>
	    <script type="text/javascript" src="assets/underscore-min.js"></script>
	    <script type="text/javascript" src="assets/bootstrap/js/bootstrap.min.js"></script>
	    @yield('app')
	</body>
</html>
