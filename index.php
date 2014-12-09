<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="">
<meta name="author" content="">
<link rel="icon" href="../../favicon.ico">

<title>Accesso riservato</title>

<!-- Bootstrap core CSS -->
<link href="libs/bootstrap/css/bootstrap.min.css" rel="stylesheet">

<!-- Custom styles for this template -->
<link href="css/signin.css" rel="stylesheet">

<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
<!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

<script src="libs/jquery/jquery-1.11.1.min.js"></script>
<script type="text/javascript" src="libs/jquery-ui/jquery-ui.min.js"></script>
<link rel="stylesheet" href="libs/jqueryuibootstrap/jquery-ui-1.9.2.custom.css" />
<script src="js/index.js"></script>

</head>

<body>

	<div class="container"  style="width:300px;" >

		<div> 
			<h2 class="form-signin-heading">Accesso riservato</h2>
			<label for="inputEmail" class="sr-only">Indirizzo email</label> <input
				type="email" id="inputEmail" class="form-control"
				placeholder="Email address" required autofocus> <label
				for="inputPassword" class="sr-only">Password</label> <input
				type="password" id="inputPassword" class="form-control"
				placeholder="Password" required>
			<div class="checkbox">
<!-- 				<label> <input type="checkbox" value="remember-me"> Remember me -->
<!-- 				</label> -->
			</div>
			<button id="login" class="btn btn-lg btn-primary btn-block"
				type="submit">Entra</button>
		</div>

		
		<div id="access_error" class="ui-state-error ui-corner-all"
			style="display: none; margin-top:1em;">
			<p>
				<span style="float: left; margin-right: .3em;"
					class="ui-icon ui-icon-alert"></span> <strong>Attenzione:</strong>
				accesso negato!
			</p>
		</div>
	</div>
	<!-- /container -->

	<!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
	<script src="libs/bootstrap/js/ie10-viewport-bug-workaround.js"></script>
</body>
</html>
