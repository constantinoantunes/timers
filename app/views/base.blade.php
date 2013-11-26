<!doctype html>
<html lang="en">
	<head>
	    <title>Timers</title>
   	    <meta charset="UTF-8">
	    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	    <link rel="stylesheet" href="assets/style.min.css"/>
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
		<script type="text/javascript">
			/*
			 * Global variables, used through the application.
			 */
			SESSION_TOKEN = '{{ Session::token() }}';
			ROUTES = {
				'startTimer' : '{{ URL::route("start-timer") }}',
				'stopTimer'  : '{{ URL::route("stop-timer") }}'
			}
		</script>
	    <script type="text/javascript" src="assets/frameworks.min.js"></script>
	    @yield('extended-scripts')
	</body>
</html>
